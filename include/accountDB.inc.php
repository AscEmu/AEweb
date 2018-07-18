<?php

class AccountDB extends Database
{
    private $connection;
    
    function __construct()
    {
        $this->connection = $this->connectToAccountDB();
    }
    
    // class functions
    function escapeString($string)
    {
        return mysqli_real_escape_string($this->connection, $string);
    }
    
    // checks
    function isNameAlreadyRegistered($name)
    {
        $accName = $this->escapeString($name);
        $query = "SELECT acc_name FROM accounts WHERE acc_name = '$accName'";
        $result = mysqli_query($this->connection, $query);
		return mysqli_num_rows($result);
    }
    
    function isEMailAlreadyRegistered($email)
    {
        $escEmail = mysqli_real_escape_string($this->connection, $email);
        $query = "SELECT email FROM accounts WHERE email = '$escEmail'";
        $result = mysqli_query($this->connection, $query);
		return mysqli_num_rows($result);
    }
    
    // execute
    function createNewAccount($name, $pass, $email)
    {
        $name = $this->escapeString($name);
		$email = $this->escapeString($pass);
		$pass = $this->escapeString($email);
        
        $password = hash('sha1', strtoupper($name . ':' . $pass));
        
        $query = "INSERT INTO accounts(acc_name, encrypted_password, banned, email, flags, banreason) VALUES('$name', '$password', '0', '$email', '24', '')";
        return mysqli_query($this->connection, $query);
    }
}