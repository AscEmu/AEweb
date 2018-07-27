<?php include 'config.php'; ?>

<?php
    $news = $webDB->getAllNewsFromDB();
    
    $newsCount = 0;
    while($row = $news->fetch_array())
    {
        $rows[] = $row;
        $newsCount++;
        
        if ($newsCount > Config\News::maxShownNews)
            break;
    }
    
    $maxNewsToShow = 3;
    $shownNewsCount = 1;
    foreach($rows as $row)
    {
        if ($shownNewsCount > $maxNewsToShow)
            break;
        
        echo '<h2>'.$row["title"].'</h2>';
        echo $row["time"].' by '.$webDB->getUserNameForId($row["userId"]).'<br>';
        echo BBCodeParser::toHtml($row["text"]);
        //todo check for user rights instead of the userid!
        if (Session::get('userid'))
        {
            echo '<div align="right">
                <form method="post" action="/admin/news" autocomplete="off">
                    <input type="hidden" name="id" value="'.$row["id"].'">
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger btn-sm" name="deleteNews"><i class="far fa-trash-alt"></i></button>
                        <button type="submit" class="btn btn-warning btn-sm" name="openEditForm"><i class="far fa-edit"></i></button>
                    </div>
                </form>
                </div>';
        }
        echo '<hr>';
        
        $shownNewsCount++;
    }
?>