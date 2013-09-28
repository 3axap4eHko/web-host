<?php

namespace WebHost\CLI;

use Phalcon\CLI\Dispatcher as PhDispatcher;

class Dispatcher extends PhDispatcher
{
    public function __construct()
    {
        $this->setDefaultTask('Default');
        $this->setTaskSuffix('Command');
        parent::__construct();
    }

}