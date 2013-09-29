<?php

namespace WebHost\CLI\Form;

use WebHost\CLI\Form;

class WebHostForm extends Form
{
    public function initialize()
    {
        $this->addLineInput('directory', 'Web-host root directory', true, 100,  '/home/www');
    }
}