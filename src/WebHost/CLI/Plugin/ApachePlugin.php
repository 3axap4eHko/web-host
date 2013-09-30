<?php

namespace WebHost\CLI\Plugin;

use Phalcon\Config;
use WebHost\CLI\Behavior\InjectServices;
use WebHost\CLI\Dispatcher;
use WebHost\Common\Plugin\AbstractPlugin;
use Phalcon\Events\Event;
use WebHost\Common\Code\Generator\ArrayConfig;
use WebHost\CLI\Command;

class ApachePlugin extends AbstractPlugin
{
    protected $reloadActions = [
        'hostCreate'
    ];

    public function setup(Event $event, Command $command)
    {
        $fileName = $command->config->configDir . '/local.config.php';

        $config = new Config(file_exists($fileName) ? include $fileName : []);

        $config->offsetSet('apache', $command->createFormApache()->requestFields()->getData());

        file_put_contents($fileName, (new ArrayConfig($config->toArray()))->generate());
    }

    public function afterDispatch(Event $event, Dispatcher $dispatcher)
    {
        if ($dispatcher->getActiveTask() instanceof \WebHost\CLI\Command\ApacheCommand && in_array($dispatcher->getActionName(), $this->reloadActions, false))
        {
            system('apache2ctl graceful');
        }
    }
}