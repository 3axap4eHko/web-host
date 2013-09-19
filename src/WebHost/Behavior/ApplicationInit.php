<?php

namespace WebHost\Behavior;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Mvc\Application as PhApplication;
use Phalcon\DI\FactoryDefault as DI;
use Phalcon\Config;

trait ApplicationInit
{
    public function init($configDir)
    {
        define('APP_MODE', strpos(strtolower(PHP_SAPI), 'cli')===false ? 'application' : 'console');
        $configDir = rtrim($configDir,'\\/');
        $di = $this->getDI();
        /** @var Config $config */
        $di->setShared('config', $config = include $configDir . '/common.php');

        $config->merge(include $configDir . '/' . APP_MODE . '.php');
        foreach($config as $section => $options)
        {
            $method = '_init' . ucfirst($section);
            if (method_exists($this, $method))
            {
                call_user_func_array([$this, $method], [$options]);
            }
        }

    }

    protected function _initModules(Config $config)
    {
        $di = $this->getDI();

    }

    protected function _initServices(Config $config)
    {
        $di = $this->getDI();

        $di->set('service', $init = function ($className, $arguments = []) use ($di) {
            return function() use($className, $arguments, $di) {
                    if ($arguments instanceof Config) {
                        $arguments = $arguments->toArray();
                    }
                    try {
                        $ref      = new \ReflectionClass($className);
                        $instance = $ref->newInstanceArgs((array)$arguments);
                        if ($instance instanceof InjectionAwareInterface) {
                            $instance->setDI($di);
                        }

                        return $instance;
                    } catch (\Exception $e) {
                        die($e);
                    }
                };
            }
        );
        /** @var Config $globalConfig */
        $globalConfig = $di->getShared('config');
        foreach ($config as $serviceName => $serviceClass)
        {
            $options = $globalConfig->get($serviceName, new Config());
            $di->set($serviceName, $init($serviceClass, $options));
        }

    }

}