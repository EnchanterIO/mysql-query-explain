<?php

/**
 * @author Lukas Lukac <services@trki.sk>
 */

use MySQLQueryExplain\Server\EventSubscriber;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require __DIR__.'/vendor/autoload.php';

$databaseConfig = new \MySQLQueryExplain\Server\Mysql\Config('localhost', 'root', 'mjfdlv', 'hack');

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new EventSubscriber($databaseConfig)
        )
    ),
    1337
);
$server->run();