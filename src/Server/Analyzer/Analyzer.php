<?php

namespace MySQLQueryExplain\Server\Analyzer;

use MySQLQueryExplain\Server\MySQL\ApplicationRepository;
use MySQLQueryExplain\Server\MySQL\PerformanceSchemaRepository;
use MySQLQueryExplain\Server\MySQL\Config;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class Analyzer
{
    /**
     * @var ApplicationRepository
     */
    private $applicationRepository;

    /**
     * @var PerformanceSchemaRepository
     */
    private $performanceSchemaRepository;

    /**
     * @param ApplicationRepository $applicationRepository
     * @param PerformanceSchemaRepository $performanceSchemaRepository
     */
    public function __construct(ApplicationRepository $applicationRepository, PerformanceSchemaRepository $performanceSchemaRepository)
    {
        $this->performanceSchemaRepository = $performanceSchemaRepository;
        $this->applicationRepository = $applicationRepository;
    }

    /**
     * @param string $queryToExplain
     *
     * @return void
     */
    public function explain($queryToExplain)
    {
        // Enable and reset stats
        $this->preparePerformanceSchema();
        $this->executeQuery($queryToExplain);
    }

    /**
     * @return Config
     */
    public function getRepositoryConnectionConfig()
    {
        return $this->performanceSchemaRepository->getConnectionConfig();
    }

    /**
     * Enable performance schema and required customers, instruments and reset their stats.
     *
     * @return void
     *
     * @throws PerformanceSchemaDisabledException
     */
    protected function preparePerformanceSchema()
    {
        if (!$this->performanceSchemaRepository->isEnabled()) {
            throw new PerformanceSchemaDisabledException('Performance schema is disabled. Unable to explain query execution!');
        }
        $this->performanceSchemaRepository->enableStats();
    }

    /**
     * @param string $query
     *
     * @return void
     */
    protected function executeQuery($query)
    {
        $this->applicationRepository->execute($query);
    }

    /**
     * @return void
     */
    protected function disablePerformanceSchema()
    {
        $this->performanceSchemaRepository->disableStats();
    }
}
