<?php

namespace WebHost\CLI\Unit;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Events\EventsAwareInterface;
use WebHost\CLI\Behavior\InjectServices;
use WebHost\Common\Behavior\EventsManagerAware;
use WebHost\Common\Behavior\InjectionAware;

class AbstractUnit implements InjectionAwareInterface, EventsAwareInterface
{
    use InjectionAware;
    use EventsManagerAware;
    use InjectServices;

    protected function fileWrite($fileName, $data, $backup = false)
    {
        if (file_exists($fileName) && $backup)
        {
            $config = $this->getDI()->getShared('config');
            $backupDir = $config->tmpDir . '/backup';
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0777, true);
            }
            rename($fileName, $backupDir . '/' . urlencode($fileName). '.' . date('Y.m.d_H.i.s.u'));
        }
        return file_put_contents($fileName, $data);
    }

    protected function fileRead($fileName)
    {
        return file_get_contents($fileName);
    }
}