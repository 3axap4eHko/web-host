<?php

ini_set('display_errors',1);
error_reporting(E_ALL);
date_default_timezone_set('US/Eastern');

use Phalcon\Loader,
    Phalcon\DI\FactoryDefault\CLI as DI,
    WebHost\CLI\Application;

$loader = new Loader();
$loader->registerNamespaces([
        'WebHost' => __DIR__ . '/../src/WebHost'
    ]);
$loader->register();

$di = new DI();
$di->setShared('loader', $loader);

$app = new Application($di);
$app->init(__DIR__ . '/../config')->handle($argv);


//print PHP_EOL . Color::colorize('WebHost', Color::FG_GREEN, Color::AT_BOLD) . PHP_EOL . PHP_EOL;

function debug()
{
    echo '<pre>';
    call_user_func_array('var_dump',func_get_args());
    die('</pre>');
}