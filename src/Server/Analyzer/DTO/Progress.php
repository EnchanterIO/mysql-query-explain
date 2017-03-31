<?php

namespace MySQLQueryExplain\Server\Analyzer\DTO;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class Progress implements \JsonSerializable
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var array
     */
    public $stats;

    /**
     * @param string $message Message explaining currently processing state
     * @param array $stats MySQL query result
     */
    public function __construct($message, array $stats = [])
    {
        $this->message = $message;
        $this->stats = $stats;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return [
            'progress' => [
                'message' => $this->message,
                'stats' => $this->stats
            ]
        ];
    }
}
