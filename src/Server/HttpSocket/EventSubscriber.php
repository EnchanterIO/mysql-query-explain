<?php

namespace MySQLQueryExplain\Server\HttpSocket;

use MySQLQueryExplain\Server\Analyzer\Analyzer;
use MySQLQueryExplain\Server\Analyzer\DTO\FailedProgress;
use MySQLQueryExplain\Server\Analyzer\DTO\Progress;
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
     *
     * @return void
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->client = $conn;

        $response = new Response($this->analyzer->getRepositoryConnectionConfig());

        $this->sendToClient($response);
    }

    /**
     * @param ConnectionInterface $conn
     * @param string $queryToExplain
     *
     * @return void
     */
    public function onMessage(ConnectionInterface $conn, $queryToExplain)
    {
        try {
            $this->analyzer->explain($queryToExplain, function(Progress $progress) {
                $this->sendToClient(new Response($progress));
            });

            $response = new Response(new Progress('Analyzer finished.'));
        } catch (\Exception $e) {
            $response = new Response(new FailedProgress($e->getMessage()));
        }

        $this->sendToClient($response);
    }

    /**
     * @param ConnectionInterface $conn
     *
     * @return void
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
     * @param \JsonSerializable $body
     *
     * @return void
     */
    private function sendToClient(\JsonSerializable $body)
    {
        $this->client->send(json_encode($body));
    }

    /**
     * @param string $message
     *
     * @return void
     */
    private function log($message)
    {
        echo $message."\n";
    }
}
