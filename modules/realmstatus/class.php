<?php

class RealmStatus extends Database
{
    private $connection;
    
    function __construct($dbhost, $dbuser, $dbpass, $dbname)
    {
        $this->connection = $this->connectToCharacterDB($dbhost, $dbuser, $dbpass, $dbname);
    }
    
    function getCharacterCount()
    {
        $query = "SELECT guid FROM characters";
        $result = mysqli_query($this->connection, $query);
        
        return $result->num_rows;
    }
}

?>