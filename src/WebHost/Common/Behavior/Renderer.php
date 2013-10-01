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
     * @param $templatePath
     * @return string
     * @throws \WebHost\Common\Exception
     */
    public function render($templatePath)
    {
        if (!$this->isValid())
        {
            throw new Exception('Invalid object rendering of class: ' . get_class($this));
        }
        ob_start();
        include $templatePath;
        return ob_get_clean();
    }
}