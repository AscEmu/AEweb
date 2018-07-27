<?php include 'content/head.tmp.php'; ?>

<?php

//news
$foundInNews = false;
$foundInNewsIds = array();

if (isset($_POST['searchString']))
{
    if (!empty($_POST['searchString']))
    {
        // search entities and build search result
        $string = $_POST['searchString'];
        
        // news
        $newsCount = 0;
        $newsResult = $webDB->getAllNewsFromDB();
        while($row = $newsResult->fetch_array())
        {
            $rows[] = $row;
        }
        
        foreach($rows as $row)
        {
            if (strpos(strtolower($row["title"]), strtolower($string)) !== false)
                $foundInNews = true;
            
            if (strpos(strtolower($row["text"]), strtolower($string)) !== false && $foundInNews == false)
                $foundInNews = true;
            
            if ($foundInNews)
            {
                array_push($foundInNewsIds, $row["id"]);
            }
        }
    }
}
?>

<div class="basic-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php
                if (isset($_POST['searchString']))
                {
                    if (empty($_POST['searchString']))
                        echo '<h2>No search string entered!</h2>';
                    else 
                    {
                        echo '<h2>Search Result for <span style="font-style: italic">"'.$_POST['searchString'].'"</span></h2>';
                        if (count($foundInNewsIds))
                        {
                            echo '<p>Found '.count($foundInNewsIds).' Results...</p>';
                            echo '<hr>';
                            foreach($foundInNewsIds as $id)
                            {
                                $newsData = $webDB->getNewsById($id);
                                while($row = $newsData->fetch_array())
                                {
                                   $newsRows = $row;
                                   echo '<a>'.$newsRows['title'].'</a>';
                                   echo '<p>'.BBCodeParser::toHtml($newsRows['text']).'</p>';
                                }
                            }
                        }
                    }
                }
                else
                {
                    echo '<h2>Use the search function...</h2>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
