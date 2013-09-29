<?php

namespace WebHost\CLI\Form;

use WebHost\CLI\Form;

class DatabaseForm extends Form
{
    public function initialize()
    {
        $this->addLineInput('host', 'Mysql connection hostname', true, 100, 'localhost');
        $this->addLineInput('username', 'Mysql connection username', true, 100, 'root');
        $this->addLineInput('password', 'Mysql connection password', true, 100, '');
        $this->addLineInput('dbname', 'Mysql connection database name', true, 100,'webhost_db');
    }
}