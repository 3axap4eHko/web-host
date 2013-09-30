<?php

return [
    'form' => [
        'types' => [
            'char' => 'Zend\Console\Prompt\Char::prompt',
            'line' => 'Zend\Console\Prompt\Line::prompt',
            'confirm' => 'Zend\Console\Prompt\Confirm::prompt',
            'select' => 'Zend\Console\Prompt\Select::prompt',
        ]
    ],
    'plugins' => [
        'WebHost\CLI\Plugin\Console' => ['dispatch'],
        'WebHost\CLI\Plugin\DefaultPlugin' => ['web-host','dispatch'],
        'WebHost\CLI\Plugin\DatabasePlugin' => ['web-host','dispatch'],
        'WebHost\CLI\Plugin\ApachePlugin' => ['web-host','dispatch'],
    ],
    'router' => [include __DIR__ . '/router.php'],
    'services' => [
        'router' => 'WebHost\CLI\Router',
        'dispatcher' => 'WebHost\CLI\Dispatcher',
        'console' => 'Zend\Console\Console::getInstance',
        'figlet' => 'Zend\Text\Figlet\Figlet',

        'unitSetup' => 'WebHost\CLI\Unit\Setup',
        'unitApacheVirtualHost' => 'WebHost\CLI\Unit\Apache\VirtualHost',

        'formApache' => 'WebHost\CLI\Form\ApacheForm',
        'formWebHost' => 'WebHost\CLI\Form\WebHostForm',
        'formDatabase' => 'WebHost\CLI\Form\DatabaseForm',
    ],

];