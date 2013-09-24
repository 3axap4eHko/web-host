<?php

namespace WebHost\CLI;

use Phalcon\CLI\Console as PhConsole;
use WebHost\Common\Behavior\ApplicationInit;

class Application extends PhConsole
{
    use ApplicationInit;

    public function handle($arguments=null)
    {

        return parent::handle([
                'task' => '',
                'action' => ''
            ]);
    }
}