<?php

namespace MySQLQueryExplain\Server\MySQL;

use MySQLQueryExplain\Server\MySQL\Exception\UnableToExecuteSqlException;

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
        $result = $sth->fetch(\PDO::FETCH_ASSOC);

        return $this->throwExceptionIfUnableToFetchResult($result, $query);
    }

    /**
     * @param string $query
     *
     * @return array
     */
    public function fetchAllAssoc($query)
    {
        $sth = $this->execute($query);
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        return $this->throwExceptionIfUnableToFetchResult($result, $query);
    }

    /**
     * @return Config
     */
    public function getConnectionConfig()
    {
        return $this->connection->getConfig();
    }

    /**
     * @param array $result
     * @param string $query
     *
     * @return array
     *
     * @throws UnableToExecuteSqlException
     */
    private function throwExceptionIfUnableToFetchResult(&$result, $query)
    {
        if ($result === false) {
            throw new UnableToExecuteSqlException('Unable to execute SQL: ' . $query);
        }

        return $result;
    }
}
