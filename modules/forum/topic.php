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
.main-category{
 width: 100%;
 background-color: #000;
 margin-top: 15px;
 padding: 10px 15px;
}

.flex-container {
  display: flex;
  background-color: #272727;
  flex-wrap: nowrap;
  margin: 0;
  padding: 10px 0 5px;
  border-width: 1px;
   border-bottom-width:1px;
   border-bottom-color:#5a5a5a;
   border-bottom-style: solid;
}

.flex-container .icon {
  padding: 0 20px 0 15px;
  text-align: center;
  line-height: 45px;
  position:relative;
}

.flex-container .subcat {
  width: 50%;
}

.flex-container .stats {
  width: 10%;
  padding-top: 5px;
  text-align: center;
}

.flex-container .latest {
  width: 30%;
  padding-top: 5px;
  text-align: right;
}

.flex-container .link {
  width: 50%;
}

.flex-container .clicks {
  width: 10%;
  text-align: center;
}

@media (max-width: 768px){
.flex-container .subcat {
  width: 40%;
}

.flex-container .stats {
  display: none;
}

.flex-container .latest {
  width: 50%;
  text-align: right;
  padding-top: 5px;
  padding-right: 15px;
}

.flex-container .link {
  width: 40%;
}

.flex-container .clicks {
  width: 50%;
  text-align: right;
  padding-right: 15px;
}
}

p.title {
    margin-bottom: 0px;
    font-weight: 700;
}

p.title a{
    margin-bottom: 0px;
    font-weight: 700;
    color: #fff;
    text-decoration: none;
}

p.title a:hover{
    margin-bottom: 0px;
    font-weight: 700;
    color: #fff;
    text-decoration: none;
}

p.link-text {
    font-size: 0.8em;
    font-weight: 700;
    margin:0;
    padding:0;
}

p.stat {
    font-size: 0.8em;
    font-weight: 700;
    margin:0;
    padding:0;
}

p.stats-single {
    font-size: 0.8em;
    font-weight: 700;
    margin:0;
    padding:1.1em 0 0 0;
}

p.info {
    margin:0;
    padding:0;
    font-size: 0.8em;
    margin-bottom: 0.7em;
}

p.links {
    margin:0;
    padding:0.8em 0 0 0;
    font-weight: 700;
}

p.links a{
    margin:0;
    padding:0;
    text-decoration: none;
    color: #fff;
}

p.latest-title {
    font-size: 0.8em;
    font-weight: 700;
    margin:0;
    padding:0;
    text-align: right;
}

p.latest {
    margin:0;
    padding:0;
    font-size: 0.8em;
    margin-bottom: 0.7em;
    text-align: right;
}
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
