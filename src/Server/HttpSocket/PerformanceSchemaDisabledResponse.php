<?php

namespace MySQLQueryExplain\Server\HttpSocket;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class PerformanceSchemaDisabledResponse extends Response
{
    public function __construct()
    {
        parent::__construct(['isPerformanceSchemaDisabled' => true]);
    }
}
