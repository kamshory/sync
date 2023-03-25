<?php
namespace Sync;

class UserAuth{

    /**
     * Database
     *
     * @var \Sync\PicoDatabase
     */
    private $database;

    /**
     * Username
     *
     * @var string
     */
    private $username = "";

    /**
     * Name
     *
     * @var string
     */
    private $name = "";

    /**
     * Username
     *
     * @var string
     */
    private $password = "";

    /**
     * Success login
     *
     * @var boolean
     */
    private $success = false;

    /**
     * Constructor
     *
     * @param \Sync\PicoDatabase $database
     * @param string $username
     * @param string $password
     */
    public function __construct($database, $username, $password)
    {
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function login()
    {
        $usename = $this->username;
        $password = sha1($this->password);
        
        $sql = "SELECT * FROM `edu_sync_account` WHERE `username` = '$usename' AND `password` = '$password' ";
        $stmt = $this->database->executeQuery($sql);
        if($stmt->rowCount() > 0)
        {
            $data = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->name = $data['name'];
            $this->success = true;
        }
    }



    /**
     * Get username
     *
     * @return  string
     */ 
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get name
     *
     * @return  string
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get success login
     *
     * @return  boolean
     */ 
    public function isSuccess()
    {
        return $this->success;
    }
}