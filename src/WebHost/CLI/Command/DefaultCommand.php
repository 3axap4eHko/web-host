<?php

namespace WebHost\CLI\Command;

use WebHost\CLI\Command;
use Zend\Console\ColorInterface as Color;
use Zend\Text\Figlet\Figlet;
use Phalcon\Config;

class DefaultCommand extends Command
{

    public function setupAction()
    {
        if ($this->inputConfirm('This action will setup the application. Are you sure you want to continue? [y/n]', 'y', 'n'))
        {
            $this->eventsManager->fire('web-host:setup', $this);
        }
    }

    public function commandsAction()
    {
        $commands = current($this->getDI()->getShared('config')->get('router'))->get('commands');
        foreach($commands as $command => $info)
        {
            $this->console->writeLine($command);
        }
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

    public function testAction()
    {
        system('ls');
    }
}