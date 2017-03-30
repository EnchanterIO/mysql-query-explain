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
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
