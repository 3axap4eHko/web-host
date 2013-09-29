<?php

namespace WebHost\CLI\Plugin;

use Phalcon\Config;
use WebHost\CLI\Behavior\InjectServices;
use WebHost\Common\Plugin\AbstractPlugin;
use Phalcon\Events\Event;
use WebHost\Common\Code\Generator\ArrayConfig;
use WebHost\CLI\Command;

class ApachePlugin extends AbstractPlugin
{
    public function setup(Event $event, Command $command)
    {
        $fileName = $command->config->configDir . '/local.config.php';

        $config = new Config(file_exists($fileName) ? include $fileName : []);

        $config->offsetSet('apache', $command->createFormApache()->requestFields()->getData());

        file_put_contents($fileName, (new ArrayConfig($config->toArray()))->generate());
    }
}