<?php include 'config.php'; ?>
<?php include 'class.php'; ?>

<?php
$forumDB = new ForumDB();

// create category array
$linkCategory = $_GET['category'];

// explode
$linkArray = explode("-", $linkCategory, 2);

// fill in named array
$linkInfo = array(
    "raw"=>$linkCategory,
    "id"=>$linkArray[0],
    "name"=>$linkArray[1],
    "parent"=>$forumDB->getParentCategoryForId($linkArray[0])
);
?>

<style>
<?php include 'style/style.css'; ?>
</style>

<!--Breadcrumbs for Categories-->
<div class="col-lg-12">
<?php
echo '<a href="'.Config\Hosting::baseURL.'forum/home">Forum</a>';

// get current name
$linkInfoName = $forumDB->getCategoryNameForId($linkInfo["id"]);
// has parent category
if ($linkInfo["parent"] != 0)
{
    $bcParentCategoryName = $forumDB->getCategoryNameForId($linkInfo["parent"]);
    echo ' / ';
    echo '<a href="'.Config\Hosting::baseURL.'forum/category/'.$linkInfo["parent"].'-'.$bcParentCategoryName.'">'.$bcParentCategoryName.'</a>';
}

echo ' / ';
echo '<a href="'.Config\Hosting::baseURL.'forum/category/'.$linkInfo["id"].'-'.$linkInfoName.'">'.$linkInfoName.'</a>';
?>
</div>

<div class="col-lg-9">

<?php
    /*$boardCategories = $forumDB->getCategories();
    
    while($row = $boardCategories->fetch_array())
    {
        $rows[] = $row;
    }
    
    foreach($rows as $row)
    {*/
        echo '<div class="main-category"><h4>'.$linkInfoName.'</h4></div>';
        //echo '<p>'.$row["description"].'</p>';
        
        // subCategories
        $subCategories = [];
        $subCatQuery = $forumDB->getSubCategoriesInCategory($linkInfo["id"]);
        while($subCat = $subCatQuery->fetch_array())
        {
            $subCategories[] = $subCat;
        }

        foreach($subCategories as $subCat)
        {
            if ($subCat["type"] != 2)
            {
                // get topics in subcategory
                $topicsInSubCategory = [];
                $subTopicsQuery = $forumDB->getTopicsInCategory($subCat["id"]);
                while($subTopics = $subTopicsQuery->fetch_array())
                {
                    $topicsInSubCategory[] = $subTopics;
                }
                
                $postsInSubTopics = 0;
                foreach($topicsInSubCategory as $subTopics)
                {
                   $postsInSubTopics = $postsInSubTopics + $forumDB->getAmountOfPostsInTopic($subTopics["id"]);
                }
                
                //echo $postsInSubTopics;
                
                //get latest topic if available
                $latestTopic = $forumDB->getLatestTopicInCategory($subCat["id"]);
                if ($latestTopic)
                {
                    $latestPost = $forumDB->getLatestPostInTopic($latestTopic["id"]);
                    
                    $topicCount = $forumDB->getAmountOfTopicsInCategory($subCat["id"]);
                    echo '  <div class="flex-container">
                                <div class="box icon"><i class="fas fa-list"></i></div>
                                <div class="box subcat">
                                    <p class="title"><a href="'.Config\Hosting::baseURL.'forum/category/'.$subCat["id"].'-'.$subCat["name"].'">'.$subCat["name"].'</a></p>
                                    <p class="info">'.$subCat["description"].'</p>
                                </div>
                                <div class="box stats">
                                    <p class="stat">Topics '.$topicCount.'</p>
                                    <p class="stat">Posts '.$postsInSubTopics.'</p>
                                </div>
                                <div class="box latest">
                                    <p class="link-text">'.$latestTopic["subject"].'</p>
                                    <p class="info">'.$webDB->getUserNameForId($latestPost["user_id"]).', '.$latestPost["date"].'</p>
                                </div>
                            </div>';
                }
                else
                {
                    echo '  <div class="flex-container">
                                <div class="box icon"><i class="fas fa-list"></i></div>
                                <div class="box subcat">
                                    <p class="title"><a href="'.Config\Hosting::baseURL.'forum/category/'.$subCat["id"].'-'.$subCat["name"].'">'.$subCat["name"].'</a></p>
                                    <p class="info">'.$subCat["description"].'</p>
                                </div>
                                <div class="box stats">
                                    <p class="stat">Topics 0</p>
                                    <p class="stat">Posts 0</p>
                                </div>
                                <div class="box latest">
                                    <p class="link-text">No forum in this category</p>
                                    <p class="info"></p>
                                </div>
                            </div>';
                }
            }
        }
        
        // links
        $subCategories = [];
        
        $subCatQuery = $forumDB->getSubCategoriesInCategory($linkInfo["id"]);
        while($subCat = $subCatQuery->fetch_array())
        {
            $subCategories[] = $subCat;
        }
        
        foreach($subCategories as $subCat)
        {
            if ($subCat["type"] == 2)
            {
                {
                    echo '  <div class="flex-container">
                                <div class="box icon"><i class="fas fa-link"></i></div>
                                <div class="box link">
                                    <p class="links"><a href="'.$subCat["description"].'">'.$subCat["name"].'</a></p>
                                </div>
                                <div class="box clicks">
                                    <!--<p class="stats-single">Clicks 1522</p>-->
                                </div>
                            </div>';
                }
            }
        }

        // topics
        $topics = [];
        
        $categoryTopics = $forumDB->getTopicsInCategory($linkInfo["id"]);
    
        while($topic = $categoryTopics->fetch_array())
        {
            $topics[] = $topic;
        }
        
        foreach($topics as $topic)
        {
            $firstPost = $forumDB->getFirstPostInTopic($topic["id"]);
            echo '  <div class="flex-container">
                        <div class="box icon"><i class="far fa-comments"></i></div>
                        <div class="box subcat">
                            <p class="title"><a href="'.Config\Hosting::baseURL.'forum/topic/'.$topic["id"].'-'.$topic["subject"].'">'.$topic["subject"].'</a></p>
                            <p class="info">Started by '.$webDB->getUserNameForId($firstPost["user_id"]).', '.$firstPost["date"].'</p>
                        </div>
                        <div class="box stats">
                            <p class="stats-single">Posts '.$forumDB->getAmountOfPostsInTopic($topic["id"]).'</p>
                        </div>
                        <div class="box latest">
                            <p class="link-text">Latest comment by '.$webDB->getUserNameForId($topic["user_id"]).'</p>
                            <p class="info">'.$topic["date"].'</p>
                        </div>
                    </div>';
        }
    //}
?>
</div>

<!--sidebar-->
<div class="col-lg-3">
<?php
$latestPosts = new LatestPosts();
?>
    <p>Latest Topics</p>
    
    <p>Latest Posts</p>
    <?php
        foreach($latestPosts->getLatestPosts() as $posts)
        {
            $topicInfo = $forumDB->getTopicById($posts["topic_id"]);
            
            echo '<p class="latest-title">In topic: '.$topicInfo["subject"].'</p>';
            echo '<p class="latest">by '.$webDB->getUserNameForId($posts["user_id"]).', '.$posts["date"].'</p>';
        }
    ?>
</div>
