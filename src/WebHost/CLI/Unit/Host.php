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
        $this->fileWrite('/etc/hosts', $this->render($this->getViewPath('WebHost\CLI','hosts.php')), true);

        return $this;
    }

    public function add(array $hosts, $IPAddress = '127.0.0.1')
    {
        $hosts = implode(' ', $hosts);
        $record = "$IPAddress\t$hosts\n";
        array_unshift($this->hosts, $record);

        return $this;
    }

    public function remove($server)
    {
        $this->hosts = array_filter($this->hosts, function($value) use ($server)
            {
                return strpos($value, $server)!==false;
            });

        return $this;
    }

}