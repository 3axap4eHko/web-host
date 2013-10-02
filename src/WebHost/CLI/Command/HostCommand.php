<?php

namespace WebHost\CLI\Command;

use WebHost\CLI\Arguments;
use WebHost\CLI\Command;
use Zend\Text\Figlet\Figlet;
use Phalcon\Config;

class HostCommand extends Command
{
    public function createAction(Arguments $arguments)
    {
        $host = $this->createUnitHost()->load();
        $servers = array_merge([$arguments->get('serverName')],
                               $arguments->get('server',[]));
        $host->add($servers);
        $this->eventsManager->fire('web-host:commandCreate',$arguments);
    }

    public function editAction()
    {

    }
}