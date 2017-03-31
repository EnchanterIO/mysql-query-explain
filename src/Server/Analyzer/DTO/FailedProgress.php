<?php

namespace MySQLQueryExplain\Server\Analyzer\DTO;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class FailedProgress extends Progress
{
    /**
     * @param string $message Message explaining currently processing state
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        $response = parent::jsonSerialize();
        $response['progress']['isError'] = true;

        return $response;
    }
}
