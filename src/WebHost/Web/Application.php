<?php

namespace WebHost\Web;

use WebHost\Common\Behavior\ApplicationInit;
use Phalcon\Mvc\Application as PhApplication;
use Phalcon\DI\FactoryDefault as DI;
use Phalcon\Config;

class Application extends  PhApplication
{
    use ApplicationInit;

}