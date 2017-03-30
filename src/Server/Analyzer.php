<?php

namespace MySQLQueryExplain\Server;

use MySQLQueryExplain\Server\MySQL\PerformanceSchemaRepository;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class Analyzer
{
    /**
     * @var PerformanceSchemaRepository
     */
    private $performanceSchemaRepository;

    /**
     * @param PerformanceSchemaRepository $performanceSchemaRepository
     */
    public function __construct(PerformanceSchemaRepository $performanceSchemaRepository)
    {
        $this->performanceSchemaRepository = $performanceSchemaRepository;
    }

    public function getRepositoryConnectionConfig()
    {
        return $this->performanceSchemaRepository->getConnectionConfig();
    }
}
