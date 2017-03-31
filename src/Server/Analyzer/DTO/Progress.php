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
    public $rows;

    /**
     * @param string $message Message explaining currently processing state
     * @param array $rows MySQL query result
     */
    public function __construct($message, array $rows = [])
    {
        $this->message = $message;
        $this->rows = $rows;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return [
            'progress' => [
                'message' => $this->message,
                'rows' => $this->rows
            ]
        ];
    }
}
