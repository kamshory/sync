<?php
namespace Sync;
class SyncRecordDatabase extends \Sync\SyncRecord
{
    public function getMap()
    {
        return array(
            'sync_database_id' => 'ID',
            'application_id' => 'Application',
            'file_name' => 'Name',
            'file_size' => 'File Size',
            'time_create' => 'Created',
            'time_upload' => 'Uploaded'
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
        return "SELECT * FROM `edu_sync_database` ORDER BY `time_create` DESC LIMIT $offset, $limit";
    }

    public function createQueryCount()
    {
        return "SELECT `sync_database_id` FROM `edu_sync_database` ";
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

