<?php

namespace MySQLQueryExplain\Server;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class EventSubscriber implements MessageComponentInterface
{
    /**
     * @var ConnectionInterface
     */
    private $client;

    /**
     * @var Analyzer
     */
    private $analyzer;

    /**
     * @param Analyzer $analyzer
     */
    public function __construct(Analyzer $analyzer)
    {
        $this->analyzer = $analyzer;
    }

    /**
     * Send back to the client that opened connection the MySQL hostname and database the queries
     * will be executed on.
     *
     * @param ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->client = $conn;
        $this->client->send(json_encode($this->analyzer->getRepositoryConnectionConfig()));
    }

    /**
     * @param ConnectionInterface $conn
     * @param string $queryToExplain
     */
    public function onMessage(ConnectionInterface $conn, $queryToExplain)
    {
        try {

        } catch (\Exception $e) {

        }
    }

    /**
     * @param ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->client = null;
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();

        $this->log("An error has occurred: {$e->getMessage()}");
    }

    /**
     * @param string $message
     */
    private function log($message)
    {
        echo $message."\n";
    }
}