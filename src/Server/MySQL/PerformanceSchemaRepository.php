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
            'SELECT THREAD_ID, EVENT_ID FROM performance_schema.events_statements_history_long WHERE SQL_TEXT LIKE "%%%s%%" ORDER BY event_id DESC LIMIT 1;',
            $query
        ));

        return new QueryIdentity($result['THREAD_ID'], $result['EVENT_ID']);
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

        $this->execute("UPDATE performance_schema.setup_consumers SET ENABLED = {$enabledValue} WHERE NAME = 'events_statements_history';");
        $this->execute("UPDATE performance_schema.setup_consumers SET ENABLED = {$enabledValue} WHERE NAME LIKE 'events_statements_%';");
        $this->execute("UPDATE performance_schema.setup_consumers SET ENABLED = {$enabledValue} WHERE NAME LIKE 'events_stages_%';");
        $this->execute("UPDATE performance_schema.setup_instruments SET ENABLED = {$enabledValue}, TIMED = 'YES' WHERE NAME LIKE 'stage/sql/%';");

        return true;
    }
}
