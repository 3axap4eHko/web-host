<?php

namespace WebHost\CLI;

use Phalcon\DI\InjectionAwareInterface;
use Phalcon\Events\EventsAwareInterface;
use WebHost\Common\Behavior\EventsManagerAware;
use WebHost\Common\Behavior\InjectionAware;

class Form implements InjectionAwareInterface, EventsAwareInterface
{
    use InjectionAware;
    use EventsManagerAware;

    protected $elements;

    protected $data;

    public function __construct()
    {
        $this->elements = new \ArrayObject();
        $this->data = [];
    }

    public function initialize(){}

    public function add($name, $type, $options, $default = null)
    {
        $this->elements->offsetSet($name, [
            'type' => $type,
            'options' => $options,
            'default' => $default,
        ]);

        return $this;
    }

    public function addCharInput($name, $text, $allowedChars, $ignoreCase = true, $allowEmpty = false, $echo = false, $default = null)
    {
        $this->add($name, 'char', array_slice(func_get_args(), 1), $default);

        return $this;
    }

    public function addLineInput($name, $text, $allowEmpty = false, $maxLength = null, $default = null)
    {
        $this->add($name, 'line', array_slice(func_get_args(), 1), $default);

        return $this;
    }

    public function addConfirmationInput($name, $text, $yesChar = 'y', $noChar = 'n', $default = null)
    {
        $this->add($name, 'confirm', array_slice(func_get_args(), 1), $default);

        return $this;
    }

    public function addSelectInput($name, $text, $options, $allowEmpty = false, $echo = false, $default = null)
    {
        $this->add($name, 'select', array_slice(func_get_args(), 1), $default);

        return $this;
    }

    public function requestFields()
    {
        $this->initialize();
        $types = $this->getDI()->get('config')->get('form')->get('types');
        foreach($this->elements as $name => $options)
        {
            $options['options'][0] = $options['options'][0] . (isset($options['default']) ? ' [' . $options['default'] . '] :' : ' :');
            $this->data[$name] = call_user_func_array($types->get($options['type']), $options['options']) ? : $options['default'];
        }

        return $this;
    }

    public function getData()
    {
        return $this->data;
    }

}