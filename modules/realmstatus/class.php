<?php

class RealmStatus extends Database
{
    private $id;
    private $connection;
    
    function __construct($id, $dbhost, $dbuser, $dbpass, $dbname)
    {
        $this->id = $id;
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