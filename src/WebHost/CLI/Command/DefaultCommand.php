<?php

namespace WebHost\CLI\Command;

use WebHost\CLI\Command;
use Zend\Console\ColorInterface as Color;
use Zend\Text\Figlet\Figlet;
use WebHost\Common\Code\Generator\ArrayConfig;
use Phalcon\Config;

class DefaultCommand extends Command
{

    public function setupAction()
    {
        if (!$this->confirm('This action will setup the application. Are you sure you want to continue? [y/n]', 'y', 'n'))
        {
            return;
        }
        $fileName = $this->config->configDir . '/local.config.php';

        $config = new Config(file_exists($fileName) ? include $fileName : []);
        $config->offsetSet('db', [
            'host' => $this->inputLine('Mysql connection hostname [localhost]:', true, 100) ? : 'localhost',
            'username' => $this->inputLine('Mysql connection username [root]:', true, 100) ? : 'root',
            'password' => $this->inputLine('Mysql connection password []:', true, 100),
            'dbname' => $this->inputLine('Mysql connection database name [webhost_db]:', true, 100) ? : 'webhost_db',
        ]);

        $config->offsetSet('web-host', [
            'webDir' => $this->inputLine('Web-host root directory [/home/www]:', true, 100) ? : '/home/www',
        ]);

        file_put_contents($fileName, (new ArrayConfig($config->toArray()))->generate());
        $this->eventsManager->fire('web-host:setup', $this->dispatcher);
    }

    public function helpAction()
    {
        $commands = current($this->getDI()->getShared('config')->get('router'))->get('commands');
        foreach($commands as $command => $info)
        {
            $description = $info->get('description', ' ');
            $this->console->write(str_pad($command, 25, ' ' , STR_PAD_LEFT), Color::BLUE);
            $this->console->write(' - ');
            $this->console->writeLine($description, Color::YELLOW);
        }
    }

    public function aboutAction()
    {
        $dir = $this->moduleManager->getModuleDir('WebHost\CLI');
        $this->figlet->setFont($dir . '/Resource/figlets/larry3d.flf');
        $this->figlet->setSmushMode(Figlet::SM_SMUSH);
        $text = $this->figlet->render('Web-Host');
        $this->console->clearScreen();
        $this->console->writeAt($text, 0, 0, Color::LIGHT_RED);
        $colors = [Color::LIGHT_RED, Color::LIGHT_BLUE];
        $idx = 0;
        while (true)
        {
            $this->console->writeAt($text, 0, 0, $colors[$idx]);
            $this->console->writeLine('Web Developer Tool v. 0.1 beta', $colors[$idx]);
            $this->console->writeLine('Powered by Phalcon and Zend Frameworks', $colors[$idx]);
            $this->console->writeLine('Press Ctrl+C for break', Color::GRAY);
            $idx = ++$idx % count($colors);
            usleep(100000);

        }
    }
}