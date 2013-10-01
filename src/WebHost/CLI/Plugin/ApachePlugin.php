<?php

namespace WebHost\CLI\Plugin;

use Phalcon\Config;
use WebHost\CLI\Arguments;
use WebHost\CLI\Behavior\InjectServices;
use WebHost\CLI\Dispatcher;
use WebHost\CLI\Unit\Apache\VirtualHost;
use WebHost\Common\Plugin\AbstractPlugin;
use Phalcon\Events\Event;
use WebHost\Common\Code\Generator\ArrayConfig;
use WebHost\CLI\Command;

class ApachePlugin extends AbstractPlugin
{
    use InjectServices;

    public function setup(Event $event, Command $command)
    {
        $fileName = $command->config->configDir . '/local.config.php';
        $config = new Config(file_exists($fileName) ? include $fileName : []);
        $config->offsetSet('apache', $command->createFormApache()->requestFields()->getData());
        file_put_contents($fileName, (new ArrayConfig($config->toArray()))->generate());
    }

    public function commandCreate(Event $event, Arguments $arguments)
    {
        $config = $this->getDI()->getShared('config');
        $virtualHost = $this->createUnitApacheVirtualHost($arguments);
        $virtualHost->setDocumentRoot($config->get('web-host')->directory . '/' . $virtualHost->getDocumentRoot());
        $virtualHost->setComment($arguments->getCommandLine());
        $virtualHost->save();
    }

    public function graceful(Event $event)
    {
        $cmd = `apache2ctl graceful`;
    }
}