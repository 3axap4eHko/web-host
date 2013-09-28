<?php

namespace WebHost\CLI;

class Arguments extends \ArrayObject
{
    public function __construct($arguments)
    {
        foreach($arguments as $argument)
        {
            if (preg_match('/^--(\w+)\=?(.+)?$/', $argument, $matches))
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
                $this->set($key, $value);
            }
            else
            {
                $this->append($argument);
            }
        }
    }

    public function has($key)
    {
        return $this->offsetExists($key);
    }

    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->offsetGet($key) : $default;
    }

    public function set($key, $value)
    {
        $this->offsetSet($key, $value);

        return $this;
    }
}