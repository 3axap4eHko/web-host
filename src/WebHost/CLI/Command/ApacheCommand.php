<?php

namespace WebHost\CLI\Command;

use Phalcon\Config;
use WebHost\CLI\Arguments;
use WebHost\CLI\Command;
use WebHost\Common\Exception;
use Zend\Console\ColorInterface as Color;

class ApacheCommand extends Command
{

    /**
     * @param Arguments $arguments
     * @example web-host apache:host:create test.loc test/public --server={www.test\,api.test} --env={APPLICATION_ENV:development} --script={/cgi-bin:/public}
     */
    public function hostCreateAction(Arguments $arguments)
    {
        $virtualHost = $this->createUnitApacheVirtualHost($this->getViewPath('WebHost\CLI','vhost.php'));
        $serverName = $arguments->get(0);
        $documentRoot = $arguments->get(1);
        $virtualHost->setServerName($serverName);
        $virtualHost->setDocumentRoot($this->config->get('web-host')->directory . '/' . $documentRoot);
        $virtualHost->setEnvVars($arguments->get('env',[]));
        $virtualHost->setScriptAliases($arguments->get('script',[]));
        $virtualHost->setServerAliases($arguments->get('server',[]));
        $virtualHost->setComment($arguments->getCommandLine());
        $fileName = $this->config->get('apache')->directory . '/sites-available/'.$serverName.'.conf';
        try {
            if (file_exists($fileName))
            {
                return $this->console->writeLine('Virtual host already exists!', Color::LIGHT_RED);
            }
            file_put_contents($fileName, $virtualHost->render());
            mkdir($virtualHost->getDocumentRoot(), 0775, true);
            $cmd = 'chown -R ' . implode('.',[$this->config->get('apache')->owner, $this->config->get('apache')->owner]) . ' ' . dirname($virtualHost->getDocumentRoot());
            system($cmd);
            if ($arguments->get('enable',true))
            {
                system('a2ensite ' . $serverName);
            }
            $this->eventsManager->fire('web-host:hostCreate',null, $serverName);
        }
        catch (Exception $e)
        {
            $this->console->writeLine('Virtual host is not configured sufficient!', Color::LIGHT_RED);
        }
    }

    public function hostRemoveAction(Arguments $arguments)
    {
        $serverName = $arguments->get(0);
        if ($this->inputConfirm('Virtual Host ' . $serverName . ' will be removed. Are you sure you want to continue? [y/n]', 'y', 'n'))
        {
            system('a2dissite ' . $serverName);
            $fileName = $this->config->get('apache')->directory . '/sites-available/'.$serverName.'.conf';
            unlink($fileName);
            $this->eventsManager->fire('web-host:hostRemove',null, $serverName);
        }
    }

    public function hostListAction()
    {
        system('apache2ctl -t -D DUMP_VHOSTS');
    }

}