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
     * @param string $query
     *
     * @return array
     */
    public function fetchAssoc($query)
    {
        $sth = $this->execute($query);

        return $sth->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $query
     *
     * @return array
     */
    public function fetchAllAssoc($query)
    {
        $sth = $this->execute($query);

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @return Config
     */
    public function getConnectionConfig()
    {
        return $this->connection->getConfig();
    }
}
