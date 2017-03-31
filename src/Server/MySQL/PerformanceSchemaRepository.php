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
     * @return bool
     */
    public function isEnabled()
    {
        $result = $this->connection->execute("SHOW GLOBAL VARIABLES LIKE 'performance_schema';");

        return $result[0]['Value'] === 'ON';
    }

    public function enableStats()
    {

    }

    public function resetStats()
    {

    }

    public function disableStats()
    {

    }

    /**
     * @return Config
     */
    public function getConnectionConfig()
    {
        return $this->connection->getConfig();
    }
}
