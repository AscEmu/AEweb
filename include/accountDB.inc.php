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
    
    function checkName($name, $register)
    {
        if ($register)
        {
            if (empty($name))
            {
                return "Please enter an account name.";
            }
            else if (strlen($name) < 3)
            {
                return "Name must have atleat 3 characters.";
            }
            else if (!preg_match("/^[a-zA-Z]+$/",$name))
            {
                return "Name must contain alphabets and NO spaces.";
            }
            else
            {
                $count = $this->isNameAlreadyRegistered($name);
                if($count != 0)
                {
                    return "Name is already in use.";
                }
            }
        }
        else
        {
            if (empty($name))
            {
                return "Please enter an account name.";
            }
            else
            {
                $count = $this->isNameAlreadyRegistered($name);
                if($count != 1)
                {
                    return "Not registered name!";
                }
            }
        }
        
        return "";
    }
    
    function checkEMail($email)
    {
        if (!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			return "Please enter valid email address.";
		}
		else
		{
			$count = $this->isEMailAlreadyRegistered($email);
			if($count != 0)
			{
				return "Provided Email is already in use.";
			}
		}
        
        return "";
    }
    
    function checkPassword($pass)
    {
        if (empty($pass))
		{
			return "Please enter password.";
		}
		else if(strlen($pass) < 6)
		{
			return "Password must have atleast 6 characters.";
		}
        
        return "";
    }
    
    function checkCorrectPassword($userName, $userPassword)
    {
        $name = $this->escapeString($userName);
		$pass = $this->escapeString($userPassword);
        
        $query = "SELECT encrypted_password FROM accounts WHERE acc_name = '$name'";
        $result = mysqli_query($this->connection, $query);
        $value = $result->fetch_assoc();
        $dbPassword = $value['encrypted_password'];
        
        $password = hash('sha1', strtoupper($name . ':' . $pass));
        
        if ($password != $dbPassword)
        {
            return "Incorrect Password.";
        }
        
        return "";
    }
    
    // execute
    function createNewAccount($name, $pass, $email)
    {
        $name = $this->escapeString($name);
		$email = $this->escapeString($email);
		$pass = $this->escapeString($pass);
        
        $password = hash('sha1', strtoupper($name . ':' . $pass));
        
        $query = "INSERT INTO accounts(acc_name, encrypted_password, banned, email, flags, banreason) VALUES('$name', '$password', '0', '$email', '24', '')";
        return mysqli_query($this->connection, $query);
    }
    
    function getIdForAccountName($userName)
    {
        $name = $this->escapeString($userName);
        
        $query = "SELECT id FROM accounts WHERE acc_name = '$name'";
        $result = mysqli_query($this->connection, $query);
        $value = $result->fetch_assoc();
        return $value['id'];
    }
    
    function deleteAccountById($id)
    {
        $query = "DELETE FROM accounts WHERE id = '$id'";
        return mysqli_query($this->connection, $query);
    }
}