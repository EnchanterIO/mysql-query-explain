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

    /**
     * @return void
     */
    public function enableStats()
    {
        $this->connection->execute("UPDATE performance_schema.setup_consumers SET enabled = 'YES' WHERE NAME = 'events_statements_history';");
        $this->connection->execute("UPDATE performance_schema.setup_consumers SET enabled = 'YES' WHERE NAME LIKE 'events_statements_%';");
        $this->connection->execute("UPDATE performance_schema.setup_consumers SET enabled = 'YES' WHERE NAME LIKE 'events_stages_%';");
        $this->connection->execute("UPDATE performance_schema.setup_instruments SET ENABLED = 'YES', TIMED = 'YES' WHERE NAME LIKE 'stage/sql/%';");
    }

    /**
     * @return void
     */
    public function resetStats()
    {
        $this->connection->execute("CALL sys.ps_truncate_all_tables(FALSE);");
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
