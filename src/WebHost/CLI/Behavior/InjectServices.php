<?php

namespace WebHost\CLI\Behavior;

/**
 * Class InjectServices
 * @package WebHost\CLI\Behavior
 *
 * @method \WebHost\CLI\Unit\Apache\VirtualHost     createUnitApacheVirtualHost()   createUnitApacheVirtualHost($arguments)
 * @method \WebHost\CLI\Unit\Host                   createUnitHost()                createUnitHost()
 * @method \WebHost\CLI\Unit\Setup                  createUnitSetup()               createUnitSetup($directory)
 *
 * @method \WebHost\CLI\Form\ApacheForm             createFormApache()              createFormApache()
 * @method \WebHost\CLI\Form\WebHostForm            createFormWebHost()             createFormWebHost()
 * @method \WebHost\CLI\Form\DatabaseForm           createFormDatabase()            createFormDatabase()
 *
 * @method \WebHost\CLI\Model\Host                  createModelHost()               createModelHost()
 */

trait InjectServices
{

    public function __call($method, $arguments)
    {
        if (preg_match('/create(Unit\w+)/', $method, $matched))
        {
            return $this->getDI()->get(lcfirst($matched[1]), $arguments);
        }

        if (preg_match('/create(Form\w+)/', $method, $matched))
        {
            return $this->getDI()->get(lcfirst($matched[1]), $arguments);
        }

        if (preg_match('/create(Model\w+)/', $method, $matched))
        {
            return $this->getDI()->get(lcfirst($matched[1]), $arguments);
        }

    }

    /**
     * @param string $module
     * @param string $template
     * @return string
     */
    public function getViewPath($module, $template)
    {
        return $this->getDI()->get('moduleManager')->getModuleDir($module) . '/Resource/views/' . $template;
    }
}