<?php

namespace MySQLQueryExplain\Server\MySQL;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class Connection
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var bool
     */
    private $isOpen;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param string $query
     *
     * @return \PDOStatement
     */
    public function execute($query)
    {
        if (!$this->isOpen) {
            $this->connect();
        }

        $sth = $this->pdo->prepare($query);
        $sth->execute();

        return $sth;
    }

    /**
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @return void
     */
    protected function connect()
    {
        $dsn = sprintf('mysql:dbname=%s;host=%s', $this->config->getDatabase(), $this->config->getHostname());

        $this->pdo = new \PDO($dsn, $this->config->getUser(), $this->config->getPassword(), [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
        $this->isOpen = true;
    }
}
