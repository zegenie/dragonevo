<?php

    require dirname(__DIR__) . '/vendor/autoload.php';

    $loop = React\EventLoop\Factory::create();
    $pusher = new MyApp\Pusher();

    $context = new React\ZMQ\Context($loop);
    $pull = $context->getSocket(ZMQ::SOCKET_PULL);
    $pull->bind('tcp://127.0.0.1:5555');
    $pull->on('message', array($pusher, 'onGameData'));

    $webSock = new React\Socket\Server($loop);
    $webSock->listen(8080, '0.0.0.0');
    $webServer = new Ratchet\Server\IoServer(
        new Ratchet\WebSocket\WsServer(
            new Ratchet\Wamp\WampServer(
                $pusher
            )
        ),
        $webSock
    );

    require dirname(__DIR__) . '/src/caspar/Cache.php';

    \b2db\Core::initialize(array(
        'dsn' => 'mysql:host=localhost;dbname=dragonevo',
        'username' => 'root',
        'password' => 'pooWZLX1'
    ));

    $loop->run();
