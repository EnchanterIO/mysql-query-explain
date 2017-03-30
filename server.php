<?php

require __DIR__.'/vendor/autoload.php';

use MySQLQueryExplain\Server\EventSubscriber;

$server = new \Ratchet\App();
$server->route('/app', new EventSubscriber());
$server->run();

