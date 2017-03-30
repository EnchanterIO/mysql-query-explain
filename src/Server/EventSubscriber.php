<?php

namespace MySQLQueryExplain\Server;

use Ratchet\ConnectionInterface;
use Ratchet\Wamp\Topic;
use Ratchet\Wamp\WampServerInterface;

/**
 * @author llukac <lukas.lukac@trivago.com>
 * @since  2017-03-30
 */
class EventSubscriber implements WampServerInterface
{
    /**
     * @inheritdoc
     */
    function onOpen(ConnectionInterface $conn)
    {
        $this->log('Connection ID: '.$conn->resourceId.' established.');
    }

    /**
     * @inheritdoc
     */
    function onClose(ConnectionInterface $conn)
    {
        $this->log('Connection ID: '.$conn->resourceId.' closed.');
    }

    /**
     * If there is an error with one of the sockets, or somewhere in the application where an Exception is thrown,
     * the Exception is sent back down the stack, handled by the Server and bubbled back up the application through this method
     * @param  ConnectionInterface $conn
     * @param  \Exception $e
     * @throws \Exception
     */
    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
    }

    /**
     * An RPC call has been received
     * @param \Ratchet\ConnectionInterface $conn
     * @param string $id The unique ID of the RPC, required to respond to
     * @param string|Topic $topic The topic to execute the call against
     * @param array $params Call parameters received from the client
     */
    function onCall(ConnectionInterface $conn, $id, $topic, array $params)
    {
        $this->log($topic);
    }

    /**
     * A request to subscribe to a topic has been made
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic The topic to subscribe to
     */
    function onSubscribe(ConnectionInterface $conn, $topic)
    {
        // TODO: Implement onSubscribe() method.
    }

    /**
     * A request to unsubscribe from a topic has been made
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic The topic to unsubscribe from
     */
    function onUnSubscribe(ConnectionInterface $conn, $topic)
    {
        // TODO: Implement onUnSubscribe() method.
    }

    /**
     * A client is attempting to publish content to a subscribed connections on a URI
     * @param \Ratchet\ConnectionInterface $conn
     * @param string|Topic $topic The topic the user has attempted to publish to
     * @param string $event Payload of the publish
     * @param array $exclude A list of session IDs the message should be excluded from (blacklist)
     * @param array $eligible A list of session Ids the message should be send to (whitelist)
     */
    function onPublish(ConnectionInterface $conn, $topic, $event, array $exclude, array $eligible)
    {
        $topic->broadcast($event);
    }

    /**
     * @param string $message
     */
    private function log($message)
    {
        echo $message . "\n";
    }
}
