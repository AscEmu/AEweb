<?php include 'config.php'; ?>
<?php include 'class.php'; ?>

<?php
$forumDB = new ForumDB();
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

.main-category h4 a {
    color: #fff;
    text-decoration: none;
}
.main-category h4 a:hover {
    color: #fff;
    text-decoration: none;
}
</style>

<div class="col-lg-12">
<?php
echo '<a href="'.Config\Hosting::baseURL.'forum/home">Forum</a>';
?>
</div>

<div class="col-lg-9">
<?php
    $boardCategories = $forumDB->getCategories();
    
    while($row = $boardCategories->fetch_array())
    {
        $rows[] = $row;
    }
    
    foreach($rows as $row)
    {
        echo '<div class="main-category"><h4><a href="'.Config\Hosting::baseURL.'forum/category/'.$row["id"].'-'.$row["name"].'">'.$row["name"].'</h4></a></div>';
        //echo '<p>'.$row["description"].'</p>';
        
        // subCategories
        $subCategories = [];
        $subCatQuery = $forumDB->getSubCategoriesInCategory($row["id"]);
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
        
        $subCatQuery = $forumDB->getSubCategoriesInCategory($row["id"]);
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
        
        $categoryTopics = $forumDB->getTopicsInCategory($row["id"]);
    
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
