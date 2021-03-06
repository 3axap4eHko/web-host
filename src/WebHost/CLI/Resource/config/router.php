<?php

return [
    'commands' => [
        /** Apache Commands */
        'create' => [
            'handler' => 'WebHost\CLI\Command\Host::create',
            'description' => 'Create virtual host',
            'map' => [
                'serverName',
                'documentRoot'
            ]
        ],
        'remove' => [
            'handler' => 'WebHost\CLI\Command\Host::remove',
            'description' => 'Remove virtual host',
            'map' => [
                'serverName',
            ]
        ],
        'list' => [
            'handler' => 'WebHost\CLI\Command\Host::list',
            'description' => 'Display server hosts list'
        ],
        'hosts' => [
            'handler' => 'WebHost\CLI\Command\Host::hosts',
            'description' => 'Display hosts list'
        ],

        /** Default Commands */
        'setup' => [
            'handler' => 'WebHost\CLI\Command\Default::setup',
            'description' => 'Setup web-host',
        ],
        'commands' => [
            'handler' => 'WebHost\CLI\Command\Default::commands',
            'description' => 'Display list of commands',
            'hide' => true
        ],
        'help' => [
            'handler' => 'WebHost\CLI\Command\Default::help',
            'description' => 'Display this help',
        ],
        'about' => [
            'handler' => 'WebHost\CLI\Command\Default::about',
            'description' => 'Display about tool',
        ],
        /** @TODO remove it */
        'test' => [
            'handler' => 'WebHost\CLI\Command\Default::test',
            'description' => 'Test action',
            'hide' => true
        ],

    ]
];