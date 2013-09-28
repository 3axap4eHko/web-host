<?php

namespace WebHost\Common\Behavior;

use WebHost\Common\Exception;

trait Renderer
{
    /**
     * @var string
     */
    protected $templatePath;

    /**
     * @return bool
     */
    protected function isValid()
    {
        return true;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        ob_start();
        include $this->templatePath;
        return ob_get_clean();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function render()
    {
        if (!$this->isValid())
        {
            throw new Exception('Invalid object rendering of class: ' . get_class($this));
        }
        return $this->__toString();
    }
}