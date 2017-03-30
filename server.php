<?php

/**
 * @author Lukas Lukac <services@trki.sk>
 */

use MySQLQueryExplain\Server\EventSubscriber;
use MySQLQueryExplain\Server\Analyzer;
use MySQLQueryExplain\Server\MySQL\Config;
use MySQLQueryExplain\Server\MySQL\PerformanceSchemaRepository;
use MySQLQueryExplain\Server\MySQL\Connection;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require __DIR__.'/vendor/autoload.php';

$databaseConfig = new Config('localhost', 'root', 'mjfdlv', 'hack');
$databaseConnection = new Connection($databaseConfig);
$performanceSchemaRepository = new PerformanceSchemaRepository($databaseConnection);

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new EventSubscriber(new Analyzer($performanceSchemaRepository))
        )
    ),
    1337
);
$server->run();