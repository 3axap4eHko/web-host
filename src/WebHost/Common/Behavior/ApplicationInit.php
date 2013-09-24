<?php

namespace WebHost\Common\Behavior;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Mvc\Application as PhApplication;
use Phalcon\DI\FactoryDefault as DI;
use Phalcon\Config;
use WebHost\Common\Module\Manager;

trait ApplicationInit
{

    protected $initOrder = [
        'modules',
        'loader',
        'services'
    ];

    public function getConfig($configDir, $configType, $configExt = '.php')
    {
        $configFilename = $configDir . DIRECTORY_SEPARATOR . $configType . $configExt;
        if (!file_exists($configFilename))
        {
            return new Config();
        }
        try
        {
            return new Config(include $configFilename);
        }
        catch (\Exception $e)
        {
            throw new \Exception(sprintf('Error including configuration file "%s"', $configFilename));
        }
    }

    public function init($configDir)
    {
        $configDir = rtrim($configDir,'\\/');
        $di = $this->getDI();
        /** @var Config $config */
        $di->setShared('config',  $config = $this->getConfig($configDir, 'global.config'));
        $config->merge($this->getConfig($configDir, 'local.config'));

        foreach($this->initOrder as $section)
        {
            $method = '_init' . ucfirst($section);
            if (method_exists($this, $method))
            {
                $options = $config->get($section, new Config());
                call_user_func_array([$this, $method], [$options]);
            }
        }

        return $this;
    }

    protected function _initModules(Config $config)
    {
        $di = $this->getDI();
        $di->setShared('moduleManager', $moduleManager = new Manager());
        $globalConfig = $di->getShared('config');
        $namespaces = [];
        foreach($config as $modulesDir => $moduleList)
        {
            foreach($moduleList as $name)
            {
                $moduleManager->addModule($modulesDir, $name);
                $namespaces[$name] = sprintf('%s/%s/src/%2$s', $modulesDir, $name);
                $moduleConfig = $this->getConfig(sprintf('%s/%s/config', $modulesDir, $name), 'config');
                $globalConfig->merge($moduleConfig);
            }
        }
        $di->getShared('loader')->registerNamespaces($namespaces, true)->register();
    }

    protected function _initLoader(Config $config)
    {

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