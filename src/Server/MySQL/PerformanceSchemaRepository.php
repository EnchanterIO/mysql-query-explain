<?php

namespace MySQLQueryExplain\Server\MySQL;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class PerformanceSchemaRepository
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Config
     */
    public function getConnectionConfig()
    {
        return $this->connection->getConfig();
    }
}
