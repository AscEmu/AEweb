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
    
    
                    
    foreach($rows as $row)
    {
        echo '<h2>'.$row["title"].'</h2>';
        //todo get formatted time and username instead of id
        echo $row["time"].' by '.$row["userId"].'<br>';
        echo html_entity_decode($row["text"]);
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
    }
?>