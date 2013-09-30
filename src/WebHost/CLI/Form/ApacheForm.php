<?php

namespace WebHost\CLI\Form;

use WebHost\CLI\Form;

class ApacheForm extends Form
{
    public function initialize()
    {
        $this->addLineInput('directory', 'Apache root directory', true, 100, '/etc/apache2');
        $this->addConfirmationInput('auto-graceful', 'Apache autograceful on changes [y/n]', 'y', 'n');
        $this->addLineInput('owner', 'Apache directory owner', true, 100, get_current_user());
        $this->addConfirmationInput('auto-database', 'Autocreate database for host [y/n]', 'y', 'n');
    }
}