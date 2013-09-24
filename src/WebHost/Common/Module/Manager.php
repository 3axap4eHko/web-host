<?php

namespace WebHost\Common\Module;

use WebHost\Common\Behavior\InjectionAware;

class Manager
{
    use InjectionAware;

    protected $_modules=[];

    public function addModule($moduleDir, $moduleName)
    {
        $this->_modules[$moduleName] =[
            'className' => sprintf('%s\Module', $moduleName),
            'path'      => sprintf('%s/%s/Module.php', $moduleDir, $moduleName),
        ];

        return $this;
    }

    public function addModules($modulesDir, array $moduleList)
    {
        foreach($moduleList as $module)
        {
            $this->addModule($modulesDir, $module);
        }

        return $this;
    }

    /**
     * @param $application
     * @return $this
     */
    public function registerModules($application)
    {
        $application->registerModules($this->_modules);

        return $this;
    }

    public function getModuleDir($moduleName)
    {
        $config = $this->getDI()->getShared('config');
        foreach($config->modules->toArray() as $dir => $modules)
        {
            if (array_search($moduleName, $modules) !== false)
            {
                return $dir . DIRECTORY_SEPARATOR . $moduleName;
            }
        }

        throw new \Exception(sprintf('Module %s not found', $moduleName));
    }
}