<?php

?>

<?php include 'content/header.cont.php'; ?>

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php include 'modules/slideshow/index.php'; ?>
            </div>
            <div class="col-lg-4">
                <h3>Welcome to AEweb</h3>
                <p>AEweb is a PHP frontend server management Website. It is and probably will be the only web-project for AscEmu servers. This project was build from scratch without deal breaking requirements.</p>
                <p>We try to build well known functionality into this project to give AscEmu users a similar good experience on the web related site as with other projects.</p>
                <p>If you have some time on your hands, join the fun and influence the development with your skills and knowledge.</p>
            </div>
        </div>
    </div>
</div>
<div class="basic-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php
                    $news = $webDB->getAllNewsFromDB();
                    while($row = $news->fetch_array())
                    {
                       $rows[] = $row;
                    }
                    
                    foreach($rows as $row)
                    {
                        echo '<h2>'.$row["title"].'</h2>';
                        echo $row["userId"];
                        echo $row["time"];
                        echo html_entity_decode($row["text"]);
                        echo '<form method="post" action="/admin/news" autocomplete="off">
                                <input type="hidden" name="id" value="'.$row["id"].'">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-danger btn-sm" name="deleteNews"><i class="far fa-trash-alt"></i></button>
                                        <button type="submit" class="btn btn-warning btn-sm" name="openEditForm"><i class="far fa-edit"></i></button>
                                    </div>
                              </form>';
                    }
                ?>
            </div>
            <div class="col-lg-4">
                <?php include 'modules/realmstatus/index.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
