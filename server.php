<?php

/**
 * @author Lukas Lukac <services@trki.sk>
 */

use MySQLQueryExplain\Server\HttpSocket\EventSubscriber;
use MySQLQueryExplain\Server\Analyzer\Analyzer;
use MySQLQueryExplain\Server\MySQL\Config;
use MySQLQueryExplain\Server\MySQL\PerformanceSchemaRepository;
use MySQLQueryExplain\Server\MySQL\ApplicationRepository;
use MySQLQueryExplain\Server\MySQL\Connection;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

require __DIR__.'/vendor/autoload.php';

$databaseConfig = new Config('localhost', 'root', '', 'hack');
$databaseConnection = new Connection($databaseConfig);
$applicationRepository = new ApplicationRepository($databaseConnection);
$performanceSchemaRepository = new PerformanceSchemaRepository($databaseConnection);
$analyzer = new Analyzer($applicationRepository, $performanceSchemaRepository);

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new EventSubscriber($analyzer)
        )
    ),
    1337
);
$server->run();