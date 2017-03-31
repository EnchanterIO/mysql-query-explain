<?php

namespace MySQLQueryExplain\Server\HttpSocket;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class SqlExceptionResponse extends Response
{
    /**
     * @param string $exceptionMessage
     */
    public function __construct($exceptionMessage)
    {
        parent::__construct([
            'isSqlError' => true,
            'message' => $exceptionMessage
        ]);
    }
}
