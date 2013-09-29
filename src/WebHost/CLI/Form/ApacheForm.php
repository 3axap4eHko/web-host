<?php

namespace WebHost\CLI\Form;

use WebHost\CLI\Form;

class ApacheForm extends Form
{
    public function initialize()
    {
        $this->addLineInput('directory', 'Apache root directory', true, 100, '/etc/apache2');
    }
}