<?php

namespace WebHost\Common\Behavior;

use Phalcon\Events\ManagerInterface;

trait EventsManagerAware
{
    /**
     * @var ManagerInterface
     */
    protected $eventsManager;

    /**
     * @return ManagerInterface
     */
    public function getEventsManager()
    {
        return $this->eventsManager;
    }

    /**
     * @param ManagerInterface $eventsManager
     *
     * @return $this
     */
    public function setEventsManager($eventsManager)
    {
        $this->eventsManager = $eventsManager;

        return $this;
    }


}