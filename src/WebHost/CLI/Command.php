<?php

namespace WebHost\CLI;

use Phalcon\CLI\Task;
use WebHost\CLI\Behavior\InjectServices;
use Zend\Console\ColorInterface as Color;
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
    public function inputConfirm($text, $yesChar, $noChar)
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
    public function inputSelect($text, $options, $allowEmpty, $echo)
    {
        return call_user_func_array('Zend\Console\Prompt\Select::prompt', func_get_args());
    }

    public function overrideFileConfirmation($fileName)
    {
        if (file_exists($fileName))
        {
            $this->console->writeLine('File "'.$fileName.'" already exists.', Color::LIGHT_RED);
            return $this->inputConfirm('Are you sure you want to override it? [y/n]', 'y', 'n');
        }

        return true;
    }
}