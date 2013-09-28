<?php

namespace WebHost\CLI;

use Phalcon\CLI\Task;

/**
 * Class Command
 * @package WebHost\CLI
 * @property \Phalcon\Config                        $config
 * @property \Zend\Console\Adapter\AdapterInterface $console
 * @property \Zend\Text\Figlet\Figlet               $figlet
 * @property \Phalcon\Mvc\View\Engine\Volt\Compiler $volt
 * @property \Phalcon\Events\Manager                $eventsManager
 * @property \WebHost\Common\Module\Manager         $moduleManager
 *
 * @method \WebHost\CLI\Unit\Apache\VirtualHost createUnitApacheVirtualHost()   createUnitApacheVirtualHost($templatePath)
 * @method \WebHost\CLI\Unit\Setup              createUnitSetup()               createUnitSetup($directory)
 *
 */

abstract class Command extends Task
{
    /**
     * @param string $module
     * @param string $template
     * @return string
     */
    public function getViewPath($module, $template)
    {
        return $this->getDI()->get('moduleManager')->getModuleDir($module) . '/Resource/views/' . $template;
    }

    public function __call($method, $arguments)
    {
        if (preg_match('/create(Unit\w+)/', $method, $matched))
        {
            return $this->getDI()->get(lcfirst($matched[1]), $arguments);
        }
    }

    /**
     * @param string $text
     * @param bool $allowEmpty
     * @param int $maxLength
     * @return mixed
     */
    public function inputLine($text, $allowEmpty, $maxLength)
    {
        return call_user_func_array('Zend\Console\Prompt\Line::prompt', func_get_args());
    }

    /**
     * @param string $text
     * @param string $allowedChars
     * @param bool $ignoreCase
     * @param bool $allowEmpty
     * @param bool $echo
     *
     * @return mixed
     */
    public function inputChar($text, $allowedChars, $ignoreCase, $allowEmpty, $echo)
    {
        return call_user_func_array('Zend\Console\Prompt\Char::prompt', func_get_args());
    }

    /**
     * @param string $text
     * @param string $yesChar
     * @param string $noChar
     *
     * @return mixed
     */
    public function confirm($text, $yesChar, $noChar)
    {
        return call_user_func_array('Zend\Console\Prompt\Confirm::prompt', func_get_args());
    }

    /**
     * @param string $text
     * @param array $options
     * @param bool $allowEmpty
     * @param bool $echo
     *
     * @return mixed
     */
    public function select($text, $options, $allowEmpty, $echo)
    {
        return call_user_func_array('Zend\Console\Prompt\Select::prompt', func_get_args());
    }
}