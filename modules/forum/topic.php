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
    "parent"=>$forumDB->getCategoryForTopicId($linkArray[0])
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
$linkInfoName = $forumDB->getTopicNameForId($linkInfo["id"]);
// has parent category
if ($linkInfo["parent"] != 0)
{
    $parentCategoryData = $forumDB->getCategoryDataById($linkInfo["parent"]);
    if ($parentCategoryData["parentId"] != 0)
    {
        $bcParentCategoryName = $forumDB->getCategoryNameForId($parentCategoryData["parentId"]);
        echo ' / ';
        echo '<a href="'.Config\Hosting::baseURL.'forum/category/'.$parentCategoryData["parentId"].'-'.$bcParentCategoryName.'">'.$bcParentCategoryName.'</a>';
        
        echo ' / ';
        echo '<a href="'.Config\Hosting::baseURL.'forum/category/'.$parentCategoryData["id"].'-'.$parentCategoryData["name"].'">'.$parentCategoryData["name"].'</a>';
    }
    else
    {
        $bcParentCategoryName = $forumDB->getCategoryNameForId($linkInfo["parent"]);
        echo ' / ';
        echo '<a href="'.Config\Hosting::baseURL.'forum/category/'.$linkInfo["parent"].'-'.$bcParentCategoryName.'">'.$bcParentCategoryName.'</a>';
    }
}

echo ' / ';
echo '<a href="'.Config\Hosting::baseURL.'forum/category/'.$linkInfo["id"].'-'.$linkInfoName.'">'.$linkInfoName.'</a>';
?>
</div>

<div class="col-lg-9">

<?php
        $firstPost = $forumDB->getFirstPostInTopic($linkInfo["id"]);
        echo '<div class="main-category"><h4>'.$linkInfoName.'</h4><p>Started by '.$webDB->getUserNameForId($firstPost["user_id"]).', '.$firstPost["date"].'</p></div>';
        echo '<div style="padding:15px; background-color:#343434;">'.$firstPost["content"].'</div><hr>';
        // posts
        $posts = [];
        
        $topicPosts = $forumDB->getPostsInTopic($linkInfo["id"]);
    
        while($post = $topicPosts->fetch_array())
        {
            $posts[] = $post;
        }
        
        foreach($posts as $post)
        {
            if ($post["id"] != $firstPost["id"])
            {
                echo '  <div style="padding:15px; background-color:#343434;"><p>By '.$webDB->getUserNameForId($post["user_id"]).'</p>
                        <p>'.$post["date"].'</p>
                        <p>'.$post["content"].'</p></div><hr>';
            }
        }
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
