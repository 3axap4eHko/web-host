<?php

return [
    'commands' => [
        'apache:host:create' => [
            'handler' => 'WebHost\CLI\Command\Apache::hostCreate',
            'description' => 'Create apache virtual host'
        ],
        'apache:host:list' => [
            'handler' => 'WebHost\CLI\Command\Apache::hostList',
            'description' => 'Display list apache virtual host'
        ],
        'setup' => [
            'handler' => 'WebHost\CLI\Command\Default::setup',
            'description' => 'Setup web-host',
        ],
        'commands' => [
            'handler' => 'WebHost\CLI\Command\Default::commands',
            'description' => 'Display list of commands',
        ],
        'help' => [
            'handler' => 'WebHost\CLI\Command\Default::help',
            'description' => 'Display this help',
        ],
        'about' => [
            'handler' => 'WebHost\CLI\Command\Default::about',
            'description' => 'Display about tool',
        ],
    ]
];