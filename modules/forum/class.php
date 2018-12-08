<?php

class ForumDB extends Database
{
    private $connection;
    
    function __construct()
    {
        $this->connection = $this->connectToWebDB();
    }

    function getCategories()
    {
        $query = "SELECT id, parentId, name, description, type FROM board_categories WHERE type = 0 ORDER BY id ASC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function getAllCategoryTypes()
    {
        $query = "SELECT id, parentId, name, description, type FROM board_categories ORDER BY id ASC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function getAvailableCategoriesForSubCategory()
    {
        $query = "SELECT id, name FROM board_categories WHERE parentId = 0 AND type = 0 ORDER BY name ASC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function getAvailableCategoriesForForum()
    {
        $query = "SELECT id, name FROM board_categories WHERE type = 0 ORDER BY name ASC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function getAvailableCategoriesForLinks()
    {
        $query = "SELECT id, name FROM board_categories WHERE type != 2 ORDER BY name ASC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function addCategory($parentId, $name, $description, $type)
    {
        $title = htmlspecialchars($name);
        $text = htmlspecialchars($description);
        $query = "INSERT INTO board_categories(parentId, name, description, type) VALUES($parentId, '$title', '$text', $type)";
        return mysqli_query($this->connection, $query);
    }
    
    function updateCategory($parentId, $name, $description, $type, $id)
    {
        $textForm = htmlspecialchars($description);
        $query = "REPLACE INTO board_categories(id, parentId, name, description, type) VALUES($id, $parentId, '$name', '$textForm', $type)";
        return mysqli_query($this->connection, $query);
    }
    
    function deleteCategoryById($id)
    {
        $query = "DELETE FROM board_categories WHERE id = '$id'";
        return mysqli_query($this->connection, $query);
    }
    
    function getCategoryById($id)
    {
        $query = "SELECT id, parentId, name, description, type FROM board_categories WHERE id = '$id'";
        return mysqli_query($this->connection, $query);
    }
    
    function getSubCategoriesInCategory($category_id)
    {
        $query = "SELECT id, parentId, name, description, type FROM board_categories WHERE parentId = '$category_id' ORDER BY id ASC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function getTopicsInCategory($category_id)
    {
        $query = "SELECT id, subject, date, category_id, user_id FROM board_topics WHERE category_id = '$category_id' ORDER BY date DESC";
        $result = mysqli_query($this->connection, $query);			
        return $result;
    }
    
    function getAmountOfTopicsInCategory($category_id)
    {
        $query = "SELECT COUNT(*) FROM board_topics WHERE category_id = '$category_id'";
        $result = mysqli_query($this->connection, $query);
        $results = mysqli_fetch_array($result);        
        return $results[0];
    }
    
    function getLatestTopicInCategory($category_id)
    {
        $query = "SELECT id, subject, date, category_id, user_id FROM board_topics WHERE category_id = '$category_id' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($this->connection, $query);
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
    
    function getFirstPostInTopic($topic_id)
    {
        $query = "SELECT content FROM board_posts WHERE topic_id = '$topic_id' ORDER BY date ASC LIMIT 1";
        $result = mysqli_query($this->connection, $query);
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
    
    function getLatestPostInTopic($topic_id)
    {
        $query = "SELECT user_id, date FROM board_posts WHERE topic_id = '$topic_id' ORDER BY date DESC LIMIT 1";
        $result = mysqli_query($this->connection, $query);
        $results = mysqli_fetch_assoc($result);
        return $results;
    }
    
    function getAmountOfPostsInTopic($topic_id)
    {
        $query = "SELECT COUNT(*) FROM board_posts WHERE topic_id = '$topic_id'";
        $result = mysqli_query($this->connection, $query);
        $results = mysqli_fetch_array($result);        
        return $results[0];
    }
    
    //Latest Posts
    function getLatestPosts()
    {
        $query = "SELECT id, content, date, topic_id, user_id FROM board_posts ORDER BY date DESC LIMIT 5";
        $result = mysqli_query($this->connection, $query);        
        return $result;
    }
    
    function getTopicById($topic_id)
    {
        $query = "SELECT id, subject, date, category_id, user_id FROM board_topics WHERE id = '$topic_id'";
        $result = mysqli_query($this->connection, $query);	
        $results = mysqli_fetch_assoc($result);		
        return $results;
    }
}

class LatestPosts
{
    public $postsArray = [];
    
    public function __construct()
    {
        $ForumDB = new ForumDB();
        
        $postDb = $ForumDB->getLatestPosts();
        while($post = $postDb->fetch_array())
        {
            $this->postsArray[] = $post;
        }
    }
    
    function getLatestPosts()
    {       
        return $this->postsArray;
    }
}

?>