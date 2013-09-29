<?php

namespace WebHost\CLI\Plugin;

use Phalcon\Config;
use WebHost\Common\Plugin\AbstractPlugin;
use Phalcon\Events\Event;
use WebHost\Common\Code\Generator\ArrayConfig;
use WebHost\CLI\Command;

class DatabasePlugin extends AbstractPlugin
{
    public function setup(Event $event, Command $command)
    {
        $fileName = $command->config->configDir . '/local.config.php';

        $config = new Config(file_exists($fileName) ? include $fileName : []);

        $config->offsetSet('db', $command->createFormDatabase()->requestFields()->getData());

        file_put_contents($fileName, (new ArrayConfig($config->toArray()))->generate());
    }
}