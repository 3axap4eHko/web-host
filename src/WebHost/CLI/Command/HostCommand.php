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
        $host->save();
        $this->eventsManager->fire('web-host:commandCreate',$arguments);
    }

    public function removeAction(Arguments $arguments)
    {
        $host = $this->createUnitHost()->load();
        $host->remove($arguments->get('serverName'));

        $this->eventsManager->fire('web-host:commandRemove',$arguments);
    }


    public function editAction(Arguments $arguments)
    {

        $this->eventsManager->fire('web-host:commandEdit',$arguments);
    }

    public function listAction(Arguments $arguments)
    {

        $this->eventsManager->fire('web-host:commandList',$arguments);
    }

    public function hostsAction(Arguments $arguments)
    {
        echo file_get_contents('/etc/hosts');
        $this->eventsManager->fire('web-host:commandHost',$arguments);
    }
}