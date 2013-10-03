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

    /**
     * @param Event $event
     * @param Arguments $arguments
     * @example web-host create test.loc test.loc/public --server={www.test.loc\,api.test.loc} --env={APPLICATION_ENV:development} --script={/cgi-bin:/public}
     */
    public function commandCreate(Event $event, Arguments $arguments)
    {
        $config = $this->getDI()->getShared('config');
        $virtualHost = $this->createUnitApacheVirtualHost($arguments);
        $virtualHost->setDocumentRoot($config->get('web-host')->directory . '/' . $virtualHost->getDocumentRoot());
        $virtualHost->setComment($arguments->getCommandLine());
        $virtualHost->save();
    }

    public function commandRemove(Event $event, Arguments $arguments)
    {
        $config = $this->getDI()->getShared('config');
        $virtualHost = $this->createUnitApacheVirtualHost($arguments);
        $virtualHost->setDocumentRoot($config->get('web-host')->directory . '/' . $virtualHost->getDocumentRoot());
        $virtualHost->remove();
    }

    public function commandList()
    {
        system('apache2ctl -t -D DUMP_VHOSTS');
    }

    public function graceful(Event $event)
    {
        $cmd = `apache2ctl graceful`;
    }
}