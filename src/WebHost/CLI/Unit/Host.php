<?php

namespace WebHost\CLI\Unit;

use WebHost\CLI\Unit\AbstractUnit;
use WebHost\Common\Behavior\Renderer;

class Host extends AbstractUnit
{
    use Renderer;

    protected $hosts;

    public function __construct()
    {
    }

    public function load()
    {
        $this->hosts = file('/etc/hosts');

        return $this;
    }

    public function save()
    {
        $this->fileWrite('/etc/hosts', implode(PHP_EOL, $this->hosts), true);

        return $this;
    }

    public function add(array $hosts, $IPAddress = '127.0.0.1')
    {
        $hosts = implode(' ', $hosts);
        $record = "$IPAddress\t$hosts";
        array_unshift($this->hosts, $record);

        return $this;
    }

}