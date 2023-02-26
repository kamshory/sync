<?php

namespace Sync;

class SyncRecord
{
    public $database;

    public $resultPerPage = 4;
    public $pageRange = 2;

    /**
     * Constructor of SyncRecord
     *
     * @param \Sync\PicoDatabase $database
     */
    public function __construct($database)
    {
        $this->database = $database;
    }

    /**
     * Get offset with page number given
     *
     * @param int $page
     * @return int
     */
    public function getOffset($page)
    {
        $offset = abs($this->resultPerPage * ($page-1));
        if($offset < 0)
        {
            $offset = 0;
        }
        return $offset;
    }

    /**
     * Get limit
     *
     * @return int
     */
    public function getLimit()
    {
        $limit = $this->resultPerPage;
        if($limit <= 0)
        {
            $limit = 1;
        }
        return $limit;
    }
}

