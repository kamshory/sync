<?php
namespace Sync;

class PicoDatabase
{

	private $username = "";
	private $password = "";
	private $databaseName = "";
	private $timezone = "Asia/Jakarta";
	private $conn;
	private $databaseServer;

	/**
	 * Summary of __construct
	 * @param \Sync\PicoDatabaseServer $databaseServer
	 * @param string $username
	 * @param string $password
	 * @param mixed $databaseName
	 * @param mixed $timezone
	 */
	public function __construct($databaseServer, $username, $password, $databaseName, $timezone) //NOSONAR
	{
		$this->databaseServer = $databaseServer;

		$this->username = $username;
		$this->password = $password;
		$this->databaseName = $databaseName;
		$this->timezone = $timezone;	
	}

	/**
	 * Get database server information
	 * @return PicoDatabaseServer Database server information
	 */
	public function getDatabaseServer()
	{
		return $this->databaseServer;
	}

	/**
	 * Connect to database
	 * @return bool true if success and false if failed
	 */
	public function connect()
	{
		$ret = false;
		date_default_timezone_set($this->timezone);
		$timezoneOffset = date("P");
		try {
			$connectionString = $this->databaseServer->getDriver() . ':host=' . $this->databaseServer->getHost() . '; port=' . $this->databaseServer->getPort() . '; dbname=' . $this->databaseName;

			$this->conn = new \PDO(
				$connectionString, 
				$this->username, 
				$this->password,
				array(
					\PDO::MYSQL_ATTR_INIT_COMMAND =>"SET time_zone = '$timezoneOffset';",
					\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION
					)
			);

			$ret = true;


		} catch (\PDOException $e) {
			echo "Connection error " . $e->getMessage();
			$ret = false;
		}
		return $ret;
	}

	/**
	 * Get database connection
	 * @return \PDO Represents a connection between PHP and a database server.
	 */
	public function getDatabaseConnection()
	{
		return $this->conn;
	}

	/**
	 * Execute query without return anything
	 * @param string $sql Query string to be executed
	 */
	public function execute($sql)
	{
		$stmt = $this->conn->prepare($sql);
		try {
			$stmt->execute();
		}
		catch(\PDOException $e)
		{
			// Do nothiing
		}
	}

	/**
	 * Execute query
	 * @param string $sql Query string to be executed
	 * @return \PDOStatement
	 */
	public function executeQuery($sql) : \PDOStatement
	{
		$stmt = $this->conn->prepare($sql);
		try {
			$stmt->execute();
		}
		catch(\PDOException $e)
		{
            // Do nothiing
		}
		return $stmt;
	}

	/**
	 * Generate 20 bytes unique ID
	 * @return string 20 bytes
	 */
	public function generateNewId()
	{
		$uuid = uniqid();
		if((strlen($uuid) % 2) == 1)
		{
			$uuid = '0'.$uuid;
		}
		$random = sprintf('%06x', mt_rand(0, 16777215));
		return sprintf('%s%s', $uuid, $random);
	}
}
