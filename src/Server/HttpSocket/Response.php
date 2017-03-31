<?php

namespace MySQLQueryExplain\Server\HttpSocket;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class Response implements \JsonSerializable
{
    /**
     * @var mixed
     */
    private $body;

    /**
     * @param mixed $body
     */
    public function __construct($body)
    {
        $this->body = $body;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return [
            'body' => $this->body
        ];
    }
}
