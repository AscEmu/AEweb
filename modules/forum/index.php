<?php include 'config.php'; ?>
<?php include 'class.php'; ?>

<style>

</style>

<h2>Forum</h2>
<hr><br>

<?php
    $boardCategories = $webDB->getCategories();
    
    while($row = $boardCategories->fetch_array())
    {
        $rows[] = $row;
    }
    
    foreach($rows as $row)
    {
        echo '<h3>'.$row["name"].'</h3>';
        echo '<p>'.$row["description"].'</p>';
        
        // subCategories
        $subCategories = [];
        
        $subCatQuery = $webDB->getSubCategoriesInCategory($row["id"]);
    
        while($subCat = $subCatQuery->fetch_array())
        {
            $subCategories[] = $subCat;
        }
        
        foreach($subCategories as $subCat)
        {
            //get latest topic if available
            $latestTopic = $webDB->getLatestTopicInCategory($subCat["id"]);
            if ($latestTopic)
                echo '<b>'.$subCat["name"].'</b> - '.$latestTopic["subject"].' by: '.$webDB->getUserNameForId($latestTopic["user_id"]).' date: '.$latestTopic["date"].'<br>';
            else
                echo '<b>'.$subCat["name"].'</b><br>';
                
        }

        // topics
        $topics = [];
        
        $categoryTopics = $webDB->getTopicsInCategory($row["id"]);
    
        while($topic = $categoryTopics->fetch_array())
        {
            $topics[] = $topic;
        }
        
        foreach($topics as $topic)
        {
            echo '<b>'.$topic["subject"].'</b>';
            echo '<p>'.$topic["date"].'</p>';
            echo '<p>By '.$webDB->getUserNameForId($topic["user_id"]).'</p>';
        }
        
        echo '<hr><br>';
    }
?>
