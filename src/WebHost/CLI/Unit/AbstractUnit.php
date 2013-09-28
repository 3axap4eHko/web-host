<?php

namespace WebHost\CLI\Unit;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Events\EventsAwareInterface;
use WebHost\Common\Behavior\EventsManagerAware;
use WebHost\Common\Behavior\InjectionAware;

class AbstractUnit implements InjectionAwareInterface, EventsAwareInterface
{
    use InjectionAware;
    use EventsManagerAware;
}