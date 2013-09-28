<?php

return [
    'configDir' => __DIR__,
    'loader' => [
        'Zend' => realpath(__DIR__ . '/../src/Zend/library/Zend')
    ],
    'modules' => [
        realpath(__DIR__ . '/../src') => ['WebHost\CLI', 'WebHost\Web']
    ],
    'services' => [

    ]
];