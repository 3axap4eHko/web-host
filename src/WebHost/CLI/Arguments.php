<?php

namespace WebHost\CLI;

use WebHost\Common\Exception;

class Arguments extends \ArrayObject
{
    /**
     * @var string
     */
    protected $commandLine;

    /**
     * @param array|null|object $arguments
     * @param array $map
     * @throws Exception if argument not mapped
     */
    public function __construct($arguments, array $map = [])
    {
        $this->commandLine = implode(' ', $arguments);
        foreach($arguments as $idx => $value)
        {
            if(!empty($map[$idx]))
            {
                $key = $map[$idx];
            } elseif (preg_match('/^--(\w+)\=?(.+)?$/', $value, $matches))
            {
                $key = $matches[1];
                $value = empty($matches[2]) ? true : $matches[2];
                if (preg_match('/^{(.+)}$/', $value, $value))
                {
                    $value = explode(',', $value[1]);
                    foreach($value as $data)
                    {
                        if (preg_match('/^(.+):(.+)$/', $data, $pairs))
                        {
                            $value = array_merge($this->get($key,[]),[$pairs[1] => $pairs[2]]);
                        }
                    }
                }
            } else
            {
                throw new Exception('Not mapped argument #' . $idx . ': ' . $value);
            }
            $this->set($key, $value);
        }
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->offsetExists($key);
    }

    /**
     * @param string $key
     * @param mixed|null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->offsetGet($key) : $default;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return $this
     */
    public function set($key, $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }

    /**
     * @param string $commandLine
     *
     * @return $this
     */
    public function setCommandLine($commandLine)
    {
        $this->commandLine = $commandLine;

        return $this;
    }

    /**
     * @return string
     */
    public function getCommandLine()
    {
        return $this->commandLine;
    }


}