<?php
set_time_limit(0);
ob_implicit_flush();

use Phalcon\Loader,
    Phalcon\DI\FactoryDefault\CLI as DI,
    Zend\Console\ColorInterface as Color,
    Zend\Console\Console;

$loader = new Loader();
$loader->registerNamespaces([
        'Zend' => realpath(__DIR__ . '/../src/Zend/library/Zend'),
    ]);
$loader->register();
$di = new DI();
$di->setShared('loader', $loader);
$di->setShared('console', $console = Console::getInstance());

$addr = '127.0.0.1';
$port = 100500;

declare(ticks=1);

$pid = pcntl_fork();
if ($pid == -1) {
     die("could not fork"); 
} else if ($pid) {
    echo 'server' . PHP_EOL;
    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_bind($sock, $addr, $port);
    socket_listen($sock, 5);
    $read[] = $sock;
    socket_select($read, $write = NULL, $except = NULL, $tv_sec = 5);
    $msgsock = socket_accept($sock);
    while (1) {
        $char = $console->readChar();
        socket_write($msgsock, $char, strlen($char));
    }
    socket_close($sock);
} else {
    echo 'client' . PHP_EOL;

    $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_connect($sock, $addr, $port);
    $x = $y =0;
    $console->hideCursor();
    echo $w = $console->getWidth();
    while(1)
    {
        $char = strtolower(socket_read($sock, 1));
        switch($char)
        {
            case 'a':
                $x = $x ? $x-1 : $x;
                break;
            case 'w':
                $y = $y ? $y-1 : $y;
                break;
            case 's':
                $y = $y<40 ? $y+1 : $y;
                break;
            case 'd':
                $x = $x<$w ? $x+1 : $x;
                break;
        }
        $console->clearScreen();
        $console->writeAt('  /)/)', $x, $y, Color::RED);
        $console->writeAt(' (0.0)', $x, $y+1, Color::RED);
        $console->writeAt('("\')(\'")', $x, $y+2, Color::RED);
    }
    socket_close($sock);
}
