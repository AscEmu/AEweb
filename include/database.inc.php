<?php

include_once 'configs/database.conf.php';

class Database
{
    private $servername;
    private $username;
    private $password;
    private $dbname;
    
    protected function connectToWebDB()
    {
        $this->servername = Config\WebDB::dbhost;
        $this->username = Config\WebDB::dbuser;
        $this->password = Config\WebDB::dbpass;
        $this->dbname = Config\WebDB::dbname;
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $conn;
    }
    
    protected function connectToAccountDB()
    {
        $this->servername = Config\AccountDB::dbhost;
        $this->username = Config\AccountDB::dbuser;
        $this->password = Config\AccountDB::dbpass;
        $this->dbname = Config\AccountDB::dbname;
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $conn;
    }
    
    protected function connectToCharacterDB($dbhost, $dbuser, $dbpass, $dbname)
    {
        $this->servername = $dbhost;
        $this->username = $dbuser;
        $this->password = $dbpass;
        $this->dbname = $dbname;
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        return $conn;
    }
}