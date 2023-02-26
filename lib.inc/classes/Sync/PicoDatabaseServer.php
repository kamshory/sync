<?php
namespace Sync;

class PicoDatabaseServer
{
	private $driver = 'mysql';
	private $host = 'localhost';
	private $port = 3306;
	
	public function __construct($driver, $host, $port)
	{
		$this->driver = $driver;
		$this->host = $host;
		$this->port = $port;
	}
	public function getDriver()
	{
		return $this->driver;
	}
	public function getHost()
	{
		return $this->host;
	}
	public function getPort()
	{
		return $this->port;
	}
	
}
