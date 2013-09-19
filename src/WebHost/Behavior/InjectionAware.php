<?php
namespace WebHost\Behavior;

use Phalcon\DiInterface;

trait InjectionAware
{
    /**
     * @var DiInterface
     */
    private $_di;

    /**
     * @return DiInterface
     */
    public function getDI()
    {
        return $this->_di;
    }

    /**
     * @param DiInterface $dependencyInjector
     *
     * @return $this
     */
    public function setDI($dependencyInjector)
    {
        $this->_di = $dependencyInjector;

        return $this;
    }
}