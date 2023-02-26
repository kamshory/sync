<?php
namespace Sync;

class SyncResult
{
    public $totalResult = 0;
    public $resultPerPage = 0;
    public $page = 0;
    public $pageRange = 2;
    public $totalPage = 0;
    public $map;
    public $data;
    
    /**
     * Constructor of SyncResult
     *
     * @param int $totalResult
     * @param int $resultPerPage
     * @param int $page
     * @param array $data
     * @param array $map
     */
    public function __construct($totalResult, $resultPerPage, $page, $pageRange, $data, $map)
    {
        $this->totalResult = $totalResult;
        $this->resultPerPage = $resultPerPage;
        $this->page = $page;
        $this->pageRange = $pageRange;
        $this->totalPage = ceil($this->totalResult / $this->resultPerPage);
        $this->map = $this->objectToArray($map);
        $this->data = $this->filter($data, $map);
    }

    public function filter($data, $map)
    {
        $keys = array_keys($map);
        foreach($data as $idx=>$val)
        {
            foreach($val as $k=>$v)
            {
                if(!in_array($k, $keys))
                {
                    unset($data[$idx][$k]);
                }
            }
        }
        return $data;
    }

    public function objectToArray($map)
    {
        $array = array();
        foreach($map as $key=>$val)
        {
            $array[] = array('key'=>$key, 'value'=>$val);
        }
        return $array;
    }
}