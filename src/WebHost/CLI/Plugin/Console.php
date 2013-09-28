<?php

namespace WebHost\CLI\Plugin;

use Phalcon\Events\Event;
use WebHost\CLI\Dispatcher;
use WebHost\Common\Plugin\AbstractPlugin;
use Zend\Console\ColorInterface as Color;

class Console extends AbstractPlugin
{
    public function beforeDispatchLoop(Event $event, Dispatcher $dispatcher)
    {
        if (!file_exists($this->getDI()->getShared('config')->configDir . '/local.config.php') && $dispatcher->getActionName()!=='setup')
        {
            $console = $this->getDI()->get('console');
            $console->writeLine('Application is not configured!', Color::LIGHT_RED);
            $console->writeLine('Please execute "web-host setup command"!', Color::LIGHT_RED);
            $event->stop();
            return false;
        }
    }
}