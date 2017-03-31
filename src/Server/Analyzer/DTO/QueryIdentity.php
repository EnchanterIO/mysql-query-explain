<?php

namespace MySQLQueryExplain\Server\Analyzer\DTO;

/**
 * @author Lukas Lukac <services@trki.sk>
 */
class QueryIdentity
{
    /**
     * @var int
     */
    private $threadId;

    /**
     * @var int
     */
    private $nestedEventId;

    /**
     * @param int $threadId
     * @param int $nestedEventId
     */
    public function __construct($threadId, $nestedEventId)
    {
        $this->threadId = (int) $threadId;
        $this->nestedEventId = (int) $nestedEventId;
    }

    /**
     * @return int
     */
    public function getThreadId()
    {
        return $this->threadId;
    }

    /**
     * @return int
     */
    public function getNestedEventId()
    {
        return $this->nestedEventId;
    }
}
