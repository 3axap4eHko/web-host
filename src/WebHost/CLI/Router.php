<?php

namespace WebHost\CLI;

use Phalcon\CLI\Router as PhRouter;
use Phalcon\Config;

class Router extends PhRouter
{
    /**
     * @var Config
     */
    protected $commands;

    public function __construct($options)
    {
        $options = new Config($options);
        $this->commands = $options->get('commands', new Config());
        parent::__construct();
    }

    public function handle($arguments=null)
    {
        if (empty($arguments[1]) || !$this->commands->offsetExists($arguments[1]))
        {
            $arguments[1] = 'help';
        }
        $route = $this->commands->get($arguments[1]);
        $command = $route->get('handler');
        list($task, $action) = explode('::', $command);
        return parent::handle([
            'task' => $task,
            'action' => $action,
            'params' => new Arguments(array_slice($arguments,2), (array)$route->get('map'))
        ]);
    }
}