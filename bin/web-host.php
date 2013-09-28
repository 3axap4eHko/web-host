<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
date_default_timezone_set('US/Eastern');

use Phalcon\Loader,
    Phalcon\DI\FactoryDefault\CLI as DI,
    WebHost\CLI\Application;

$loader = new Loader();
$loader->registerNamespaces([
        'WebHost' => realpath(__DIR__ . '/../src/WebHost')
    ]);
$loader->register();

$di = new DI();
$di->setShared('loader', $loader);

$app = new Application($di);
$app->init(__DIR__ . '/../config')->handle($argv);

function debug()
{
    call_user_func_array('var_dump',func_get_args());
    die(PHP_EOL);
}