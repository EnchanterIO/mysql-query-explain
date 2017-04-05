<?php

namespace MySQLQueryExplain\Server\MySQL;

use MySQLQueryExplain\Server\Analyzer\DTO\QueryIdentity;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class PerformanceSchemaRepository extends BaseRepository
{
    /**
     * @return bool
     */
    public function enableStats()
    {
        return $this->isEnabled() && $this->updateStats(true);
    }

    /**
     * @return void
     */
    public function disableStats()
    {
        $this->updateStats(false);
    }

    /**
     * @return void
     */
    public function resetStats()
    {
        $this->execute("CALL sys.ps_truncate_all_tables(FALSE);");
    }

    /**
     * @param string $query
     *
     * @return QueryIdentity
     */
    public function collectQueryIdentity($query)
    {
        $result = $this->fetchAssoc(sprintf(
            'SELECT THREAD_ID, EVENT_ID, digest FROM performance_schema.events_statements_history_long WHERE SQL_TEXT LIKE "%%%s%%" ORDER BY event_id DESC LIMIT 1;',
            $query
        ));

        if (empty($result) || strlen($result['THREAD_ID']) === 0 || strlen($result['EVENT_ID']) === 0 || strlen($result['digest']) === 0) {
            throw new \InvalidArgumentException('Unable to retrieve query identity!');
        }

        return new QueryIdentity($result['THREAD_ID'], $result['EVENT_ID'], $result['digest']);
    }

    /**
     * @param QueryIdentity $queryIdentity
     *
     * @return array
     */
    public function collectExecutionStages(QueryIdentity $queryIdentity)
    {
        return $this->fetchAllAssoc(sprintf(
            "SELECT thread_id, event_name AS en, timer_wait/1e9 AS `timer_wait_ms` FROM performance_schema.events_stages_history_long WHERE THREAD_ID = %d AND NESTING_EVENT_ID = %d ORDER BY event_id DESC;",
            $queryIdentity->getThreadId(),
            $queryIdentity->getNestedEventId()
        ));
    }

    /**
     * @param QueryIdentity $queryIdentity
     *
     * @return array
     */
    public function collectStatementAnalysis(QueryIdentity $queryIdentity)
    {
        return $this->fetchAllAssoc(sprintf(
            'SELECT full_scan, exec_count, total_latency, lock_latency, rows_sent, rows_examined, tmp_tables, tmp_disk_tables, rows_sorted, sort_merge_passes FROM sys.statement_analysis WHERE digest = "%s"',
            $queryIdentity->getDigest()
        ));
    }

    /**
     * @return bool
     */
    private function isEnabled()
    {
        $result = $this->fetchAssoc("SHOW GLOBAL VARIABLES LIKE 'performance_schema';");

        return $result['Value'] === 'ON';
    }

    /**
     * @param bool $enable
     *
     * @return bool
     */
    private function updateStats($enable = true)
    {
        $enabledValue = $enable ? 'YES' : 'NO';

        $this->execute(sprintf("UPDATE performance_schema.setup_consumers SET ENABLED = '%s' WHERE NAME LIKE 'events_statements_history%%';", $enabledValue));
        $this->execute(sprintf("UPDATE performance_schema.setup_consumers SET ENABLED = '%s' WHERE NAME LIKE 'events_statements_%%';", $enabledValue));
        $this->execute(sprintf("UPDATE performance_schema.setup_consumers SET ENABLED = '%s' WHERE NAME LIKE 'events_stages_%%';", $enabledValue));
        $this->execute(sprintf("UPDATE performance_schema.setup_instruments SET ENABLED = '%s' WHERE NAME LIKE 'stage/sql/%%';", $enabledValue));

        return true;
    }
}
