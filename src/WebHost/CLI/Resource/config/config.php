<?php

return [
    'services' => [
        'router' => 'WebHost\CLI\Router',
        'dispatcher' => 'WebHost\CLI\Dispatcher',
        'console' => 'Zend\Console\Console::getInstance',
        'figlet' => 'Zend\Text\Figlet\Figlet',

        'unitSetup' => 'WebHost\CLI\Unit\Setup',
        'unitApacheVirtualHost' => 'WebHost\CLI\Unit\Apache\VirtualHost'
    ],
    'router' => [include __DIR__ . '/router.php'],
    'plugins' => [
        'WebHost\CLI\Plugin\Console' => ['dispatch'],
        'WebHost\CLI\Plugin\ApachePlugin' => ['web-host'],
    ]

];