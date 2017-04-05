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
     * @var string
     */
    private $digest;

    /**
     * @param int $threadId
     * @param int $nestedEventId
     * @param string $digest
     */
    public function __construct($threadId, $nestedEventId, $digest)
    {
        $this->threadId = (int) $threadId;
        $this->nestedEventId = (int) $nestedEventId;
        $this->digest = $digest;
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

    /**
     * @return string
     */
    public function getDigest()
    {
        return $this->digest;
    }
}
