<?php
use Phalcon\Loader,
    Phalcon\DI\FactoryDefault as DI,
    WebHost\Web\Application;

ini_set('display_errors',1);
error_reporting(E_ALL);
date_default_timezone_set('US/Eastern');

try {
    $loader = new Loader();
    $loader->registerNamespaces([
            'WebHost' => __DIR__ . '/../src/WebHost'
        ]);
    $loader->register();
    $di = new DI();
    $di->setShared('loader', $loader);

    $app = new Application($di);
    $app->init(__DIR__ . '/../config');


} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e){
    echo $e->getMessage();
}

function debug()
{
    echo '<pre>';
    call_user_func_array('var_dump',func_get_args());
    die('</pre>');
}