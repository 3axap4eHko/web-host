<?php

namespace WebHost\CLI\Plugin;

use Phalcon\Config;
use WebHost\CLI\Dispatcher;
use WebHost\Common\Plugin\AbstractPlugin;
use Phalcon\Events\Event;

class ApachePlugin extends AbstractPlugin
{
    public function setup(Event $event, Dispatcher $dispatcher)
    {
        $dispatcher->forward([
            'task' => 'WebHost\CLI\Command\Apache',
            'action' => 'setup'
        ]);
    }
}