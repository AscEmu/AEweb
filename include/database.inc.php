<?php

include_once 'configs/database.conf.php';

class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    
    protected function connectToAccountDB()
    {
        $this->servername = Config\AccountDB::dbhost;
        $this->username = Config\AccountDB::dbuser;
        $this->password = Config\AccountDB::dbpass;
        $this->dbname = Config\AccountDB::dbname;
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $conn;
    }
}