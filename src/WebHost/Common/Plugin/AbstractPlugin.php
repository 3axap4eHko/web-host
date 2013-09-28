<?php

namespace WebHost\Common\Plugin;

use Phalcon\Mvc\User\Plugin as PhPlugin,
    WebHost\Common\Behavior\InjectionAware;

class AbstractPlugin extends PhPlugin
{
    use InjectionAware;

    public function __construct($dependencyInjector)
    {
        $this->setDI($dependencyInjector);
    }

}