<?php

class RealmStatus extends Database
{
    private $id;
    private $connection;
    private $adress;
    private $port;
    
    function __construct($id, $dbhost, $dbuser, $dbpass, $dbname, $adress, $port)
    {
        $this->id = $id;
        $this->connection = $this->connectToCharacterDB($dbhost, $dbuser, $dbpass, $dbname);
        $this->adress = $adress;
        $this->port = $port;
    }

    function getCharacterCount()
    {
        $query = "SELECT guid FROM characters";
        $result = mysqli_query($this->connection, $query);
        
        return $result->num_rows;
    }
}

?>