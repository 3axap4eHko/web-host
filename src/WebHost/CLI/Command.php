<?php

namespace WebHost\CLI;

use Phalcon\CLI\Task;
use WebHost\CLI\Behavior\InjectServices;

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
 */

abstract class Command extends Task
{
    use InjectServices;

    /**
     * @param string $module
     * @param string $template
     * @return string
     */
    public function getViewPath($module, $template)
    {
        return $this->getDI()->get('moduleManager')->getModuleDir($module) . '/Resource/views/' . $template;
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