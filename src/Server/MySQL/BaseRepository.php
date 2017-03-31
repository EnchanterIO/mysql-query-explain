<?php

namespace MySQLQueryExplain\Server\MySQL;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class BaseRepository
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
     * @param string $query
     *
     * @return \PDOStatement
     */
    public function execute($query)
    {
        return $this->connection->execute($query);
    }

    /**
     * @return Config
     */
    public function getConnectionConfig()
    {
        return $this->connection->getConfig();
    }
}
