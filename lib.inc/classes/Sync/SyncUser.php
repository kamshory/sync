<?php
namespace Sync;
class SyncUser extends \Sync\SyncRecord
{
    public function getMap()
    {
        return array(
            'sync_account_id' => 'ID',
            'username' => 'Username',
            'name' => 'Name',
            'time_create' => 'Created',
            'blocked' => 'Blocked',
            'active' => 'Active'
        );                
    }

    /**
     * Create query with page number given
     *
     * @param int $page
     * @return string
     */
    public function createQuery($page)
    {
        $offset = $this->getOffset($page);
        $limit = $this->getLimit();
        return "SELECT * FROM `edu_sync_account` ORDER BY `time_create` DESC LIMIT $offset, $limit";
    }

    public function createQueryCount()
    {
        return "SELECT `sync_account_id` FROM `edu_sync_account` ";
    }

    /**
     * Get record with page number given
     *
     * @param int $page
     * @return \Sync\SyncResult
     */
    public function getPage($page)
    {
        if($page < 1)
        {
            $page = 1;
        }
        $queryTotal = $this->createQueryCount();
        $totalResult = $this->database->executeQuery($queryTotal)->rowCount();
        $query = $this->createQuery($page);
        $data = $this->database->executeQuery($query)->fetchAll(\PDO::FETCH_ASSOC);
        return new \Sync\SyncResult($totalResult, $this->resultPerPage, $page, $this->pageRange, $data, $this->getMap());
    }
}

