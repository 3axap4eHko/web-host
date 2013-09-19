<?php

namespace WebHost;

use Phalcon\CLI\Console as PhConsole;
use WebHost\Behavior\ApplicationInit;

class Console extends PhConsole
{
    use ApplicationInit;


}