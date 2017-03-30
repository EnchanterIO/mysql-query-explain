<?php

namespace MySQLQueryExplain\Server\Mysql;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class Config implements \JsonSerializable
{
    /**
     * @var string
     */
    private $hostname;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $database;

    /**
     * @param $hostname
     * @param $user
     * @param $password
     * @param $database
     */
    public function __construct($hostname, $user, $password, $database)
    {
        $this->hostname = $hostname;
        $this->user = $user;
        $this->password = $password;
        $this->database = $database;
    }
    
    /**
     * @return string
     */
    public function getHostname()
    {
        return $this->hostname;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @inheritdoc
     */
    function jsonSerialize()
    {
        return json_encode(['config' => [
            'hostname' => $this->hostname,
            'database' => $this->database
        ]]);
    }
}
