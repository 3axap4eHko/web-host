<?php

namespace WebHost\CLI\Command;

use Phalcon\Config;
use WebHost\CLI\Arguments;
use WebHost\CLI\Command;
use WebHost\Common\Code\Generator\ArrayConfig;
use WebHost\Common\Exception;
use Zend\Console\ColorInterface as Color;

class ApacheCommand extends Command
{

    public function setupAction()
    {
        $fileName = $this->config->configDir . '/local.config.php';

        $config = new Config(file_exists($fileName) ? include $fileName : []);

        $config->offsetSet('apache', [
            'directory' => $this->inputLine('Apache root directory [/etc/apache2]:', true, 100) ? : '/etc/apache2',
        ]);

        file_put_contents($fileName, (new ArrayConfig($config->toArray()))->generate());
    }

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
        $virtualHost->setDocumentRoot($this->config->get('web-host')->webDir . '/' . $documentRoot);
        $virtualHost->setEnvVars($arguments->get('env',[]));
        $virtualHost->setScriptAliases($arguments->get('script',[]));
        $virtualHost->setServerAliases($arguments->get('server',[]));

        $fileName = $this->config->get('apache')->directory . '/sites-available/'.$serverName.'.conf';
        try {
            echo $virtualHost->render();
            exit;
            file_put_contents($fileName, $virtualHost->render());
        }
        catch (Exception $e)
        {
            $this->console->writeLine('Virtual host is not configured sufficient!', Color::LIGHT_RED);
        }
    }

    public function hostListAction()
    {
        system('apache2ctl -t -D DUMP_VHOSTS');
    }

}