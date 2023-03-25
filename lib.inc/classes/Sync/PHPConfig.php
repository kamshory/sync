<?php

namespace Sync;
class PHPConfig
{
    public $path = "php.ini";
    public $data = array();

    /**
     * Constructor of PHPConfig
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    public function load()
    {
        // Parse php.ini
        $this->data = parse_ini_file($this->path);
    }

    public function loadAndApply()
    {
        $this->data = parse_ini_file($this->path);
        $this->apply();
    }

    public function apply($data = null)
    {
        if($data == null)
        {
            $data = $this->data;
        }
        foreach($data as $key=>$value)
        {
            ini_set($key, $value);
        }
    }

    public function update($data)
    {
        $this->load();
        $currentData = $this->data;
        foreach($data as $key=>$value)
        {
            $currentData[$key] = $value;
        }
        $this->save($currentData);
    }

    public function save($data = null)
    {
        if($data == null)
        {
            $data = $this->data;
        }
        $lines = array();
        foreach($data as $key=>$value)
        {
            $lines[] = $key . "=" . $value;
        }
        file_put_contents($this->path, implode("\r\n", $lines));
    }

    /**
     * Get config as object
     * @return \stdClass
     */
    public function getObject()
    {
        return json_decode(json_encode($this->data), false);
    }
}