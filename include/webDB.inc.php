<?php

class WebDB extends Database
{
    private $connection;
    
    function __construct()
    {
        $this->connection = $this->connectToWebDB();
    }
    
    // class functions
    function runQuery($query)
    {
        $result = mysqli_query($this->connection, $query);
        return $result;
    }
    
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
    
    function getAvatar($id)
    {
        $query = "SELECT avatar FROM users WHERE id = '$id'";
        $result = mysqli_query($this->connection, $query);
        $userFields = $result->fetch_assoc();
        return $userFields['avatar'];
    }
    
    function setNewAvatar($id, $avatarName)
    {
        $query = "UPDATE users SET avatar = '$avatarName' WHERE id = '$id'";
        return mysqli_query($this->connection, $query);
    }
    
    function getUserNameForId($id)
    {
        $query = "SELECT displayName FROM users WHERE id = '$id'";
        $result = mysqli_query($this->connection, $query);
        $userFields = $result->fetch_assoc();
        return $userFields['displayName'];
    }
    
    // account panel
    function setNewName($id, $newName)
    {
        $queryCheck = "SELECT * FROM users WHERE displayName = '$newName'";
        $result = mysqli_query($this->connection, $queryCheck);
        if (!$result->num_rows)
        {
           $query = "UPDATE users SET displayName = '$newName' WHERE id = '$id'";
            return mysqli_query($this->connection, $query); 
        }
        return 0;
    }
    
    // news
    function getAllNewsFromDB()
    {
        $query = "SELECT id, userId, title, time, text, image FROM news ORDER BY id DESC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function addNewsToDB($userId, $title, $text)
    {
        $textForm = htmlspecialchars($text);
        $query = "INSERT INTO news(userId, title, time, text, image) VALUES($userId, '$title', NOW(), '$textForm', '')";
        return mysqli_query($this->connection, $query);
    }
    
    function updateNewsInDB($userId, $title, $text, $id)
    {
        $textForm = htmlspecialchars($text);
        $query = "REPLACE INTO news(id, userId, title, time, text, image) VALUES($id, $userId, '$title', NOW(), '$textForm', '')";
        return mysqli_query($this->connection, $query);
    }
    
    function deleteNewsById($id)
    {
        $query = "DELETE FROM news WHERE id = '$id'";
        return mysqli_query($this->connection, $query);
    }
    
    function getNewsById($id)
    {
        $query = "SELECT id, userId, title, time, text, image FROM news WHERE id = '$id'";
        return mysqli_query($this->connection, $query);
    }
    
    // slideshow
    function getLatestSlides()
    {
        $query = "SELECT sort, imageName, caption, author FROM slideshow ORDER BY sort DESC LIMIT 4";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function getAllSlides()
    {
        $query = "SELECT sort, imageName, caption, author FROM slideshow ORDER BY sort DESC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function getSlideById($id)
    {
        $query = "SELECT sort, imageName, caption, author FROM slideshow WHERE sort = '$id'";
        return mysqli_query($this->connection, $query);
    }
    
    function addSlideToDB($imageName, $caption, $author)
    {
        $text = $this->escapeString($caption);
        $textForm = htmlspecialchars($text);
        $query = "INSERT INTO slideshow(sort, imageName, caption, author) VALUES(NULL, '$imageName', '$textForm', '$author')";
        return mysqli_query($this->connection, $query);
    }
    
    function updateSlideInDB($id, $image, $caption, $author)
    {
        $text = $this->escapeString($caption);
        $textForm = htmlspecialchars($text);
        $query = "";
        
        if (!empty($image))
            $query = "REPLACE INTO slideshow(sort, imageName, caption, author) VALUES($id, '$image', '$textForm', '$author')";
        else
            $query = "UPDATE slideshow SET caption = '$textForm', author = '$author' WHERE sort = $id";
        
        return mysqli_query($this->connection, $query);
    }
    
    function deleteSlideById($id)
    {
        $query = "DELETE FROM slideshow WHERE sort = '$id'";
        return mysqli_query($this->connection, $query);
    }
    
    // realms
    function setRealmData($id, $host, $user, $password, $database, $name, $description, $version)
    {
        $query = "REPLACE INTO realms(`id`, `host`, `user`, `password`, `database`, `name`, `description`, `version`, `flags`) VALUES($id, '$host', '$user', '$password', '$database', '$name', '$description', '$version', 0)";
        return mysqli_query($this->connection, $query);
    }
    
    function deleteRealmById($id)
    {
        $query = "DELETE FROM realms WHERE id = '$id'";
        return mysqli_query($this->connection, $query);
    }
    
    function getRealmInfoFromDB($id)
    {
        $query = "SELECT `id`, `host`, `user`, `database`, `name`, `description`, `version` FROM realms WHERE id = $id";
        $result = mysqli_query($this->connection, $query);
        $results = $result->fetch_assoc();
        return $results;
    }
    
}