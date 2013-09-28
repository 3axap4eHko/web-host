<?php

namespace WebHost\Common\Behavior;


trait Populate
{
    public function setOptions($options)
    {
        foreach($options as $key => $value)
        {
            $method = 'set' . ucfirst($key);
            if (method_exists($this, $method))
            {
                call_user_func_array([$this, $method],[$value]);
            }
        }

        return $this;
    }
}