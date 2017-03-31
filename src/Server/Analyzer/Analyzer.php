<?php

namespace MySQLQueryExplain\Server\Analyzer;

use MySQLQueryExplain\Server\Analyzer\Exception\PerformanceSchemaDisabledException;
use MySQLQueryExplain\Server\Analyzer\DTO\Progress;
use MySQLQueryExplain\Server\MySQL\ApplicationRepository;
use MySQLQueryExplain\Server\MySQL\Exception\UnableToExecuteSqlException;
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
     * @param callable $progressCallback
     *
     * @return void
     *
     * @throws PerformanceSchemaDisabledException
     * @throws UnableToExecuteSqlException
     */
    public function explain($queryToExplain, callable $progressCallback)
    {
        $progressCallback(new Progress('Preparing performance schema...'));
        $this->preparePerformanceSchema();
        $progressCallback(new Progress('Performance schema successfully prepared.'));

        $progressCallback(new Progress('Executing given query...'));
        $queryResult = $this->applicationRepository->fetchAllAssoc($queryToExplain);
        $progressCallback(new Progress('Query executed.', $queryResult));

        $queryIdentity = $this->performanceSchemaRepository->collectQueryIdentity($queryToExplain);

        $progressCallback(new Progress('Collecting query execution stages...'));
        $executionStages = $this->performanceSchemaRepository->collectExecutionStages($queryIdentity);
        $progressCallback(new Progress('Execution stages:', $executionStages));
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
        if (!$this->performanceSchemaRepository->enableStats()) {
            throw new PerformanceSchemaDisabledException('Performance schema is disabled. Unable to explain query execution!');
        }
    }

    /**
     * @return void
     */
    protected function disablePerformanceSchema()
    {
        $this->performanceSchemaRepository->disableStats();
    }
}
