<?php

namespace WebHost\CLI;

use Phalcon\CLI\Console as PhConsole;
use WebHost\Common\Behavior\ApplicationInit;
use WebHost\Common\Exception;
use Zend\Console\ColorInterface as Color;

class Application extends PhConsole
{
    use ApplicationInit;

    public function handle($arguments=null)
    {
        try{
            return parent::handle($arguments);
        }catch (Exception $e)
        {
            $console = $this->getDI()->getConsole();
            $console->writeLine($e->getMessage(), Color::LIGHT_RED);
        }

    }
}