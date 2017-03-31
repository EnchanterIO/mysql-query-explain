<?php

namespace MySQLQueryExplain\Server\MySQL;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class PerformanceSchemaRepository extends BaseRepository
{
    /**
     * @return bool
     */
    public function isEnabled()
    {
        $result = $this->execute("SHOW GLOBAL VARIABLES LIKE 'performance_schema';");

        return $result[0]['Value'] === 'ON';
    }

    /**
     * @return void
     */
    public function enableStats()
    {
        $this->updateStats(true);
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
     * @param bool $enable
     *
     * @return void
     */
    private function updateStats($enable = true)
    {
        $enabledValue = $enable ? 'YES' : 'NO';

        $this->execute("UPDATE performance_schema.setup_consumers SET ENABLED = {$enabledValue} WHERE NAME = 'events_statements_history';");
        $this->execute("UPDATE performance_schema.setup_consumers SET ENABLED = {$enabledValue} WHERE NAME LIKE 'events_statements_%';");
        $this->execute("UPDATE performance_schema.setup_consumers SET ENABLED = {$enabledValue} WHERE NAME LIKE 'events_stages_%';");
        $this->execute("UPDATE performance_schema.setup_instruments SET ENABLED = {$enabledValue}, TIMED = 'YES' WHERE NAME LIKE 'stage/sql/%';");
    }
}
