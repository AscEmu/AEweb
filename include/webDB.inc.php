<?php

class WebDB extends Database
{
    private $connection;
    
    function __construct()
    {
        $this->connection = $this->connectToWebDB();
    }
    
    // class functions
    function escapeString($string)
    {
        return mysqli_real_escape_string($this->connection, $string);
    }
    
    function getAllUserDataForAccount($id)
    {
        $query = "SELECT id, displayName, avatar FROM users WHERE id = '$id'";
        $result = mysqli_query($this->connection, $query);			
        $results = $result->fetch_assoc();
        return $results;
    }
    
    function createWebData($id, $displayName)
    {
        $displayName = $this->escapeString($displayName);

        $query = "INSERT INTO users(id, displayName, avatar) VALUES($id, '$displayName', 'default.jpg')";
        return mysqli_query($this->connection, $query);
    }
}