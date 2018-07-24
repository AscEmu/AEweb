
<?php include 'content/header.cont.php'; ?>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
<?php

// create news
if (isset($_POST['createNews']))
{
    $userId = $_POST['userId'];
    $title = $_POST['title'];
    $text = $_POST['text'];
    
    $newsQuery = $webDB->addNewsToDB($userId, $title, $text);
    if (!$newsQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> News not created in database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> News created in database.
            </div>';
    }
}

// load data in case of a change request
if (isset($_POST['openEditForm']))
{
    $newsId = $_POST['id'];
    
    $newsQuery = $webDB->getNewsById($newsId);
    if (!$newsQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Tried to load news with id '.$newsId;
        echo '    </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> News loaded.
            </div>';
    }
    
    while($row = $newsQuery->fetch_array())
    {
       $ChangeRows = $row;
    }
}

// change news in admin/news page
if (isset($_POST['editNews']))
{
    $userId = $_POST['userId'];
    $title = $_POST['titelChange'];
    $text = $_POST['textChange'];
    $id = $_POST['id'];
    
    $newsQuery = $webDB->updateNewsInDB($userId, $title, $text, $id);
    if (!$newsQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> News not updated in database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> News updated in database.
            </div>';
    }
}

// delete news
if (isset($_POST['deleteNews']))
{
    $newsId = $_POST['id'];
    
    $newsQuery = $webDB->deleteNewsById($newsId);
    if (!$newsQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> News not deleted from database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> News deleted from database.
            </div>';
    }
}

// get news from db
$news = $webDB->getAllNewsFromDB();
while($row = $news->fetch_array())
{
   $rows[] = $row;
}

?>

<!-- hidden page form start -->
    <div id="overlay-page" onclick="overlayOff('page')">
        <div id="page">
            <div id="page-form">
            <form method="post" action="/admin/news" autocomplete="off">
                <input type="hidden" name="actionType" value="2">
                <input type="hidden" name="id" value="<?php echo isset($ChangeRows["id"]) ? $ChangeRows["id"] : 0; ?>">
                    <input type="hidden" name="userId" value="<?php echo Session::get('userid') ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" id="titelChange" name="titelChange" value="<?php echo isset($ChangeRows["title"]) ? $ChangeRows["title"] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="uploadChange">Upload lead image</label>
                        <input type="file" class="form-control-file" id="uploadChange">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="textChange" name="textChange" rows="15" ></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="editNews">Update News</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- hidden page form ends -->

        </div>
    </div>
</div>

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2><i class="far fa-newspaper"></i> Latest News</h2>
                <table id="news-list" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>title</th>
                            <th>User ID</th>
                            <th>time</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                foreach($rows as $row)
                                {
                                    $pg = "'page'";
                                    $text = isset($row["text"]) ? $row["text"] : "";
                                    echo '<tr>';
                                    echo     '<td>'.$row["id"].'</td>';
                                    echo     '<td>'.$row["title"].'</td>';
                                    echo     '<td>'.$row["userId"].'</td>';
                                    echo     '<td>'.$row["time"].'</td>';
                                    echo     '<td>';
                                    echo     '<form method="post" action="/admin/news" autocomplete="off">
                                                <input type="hidden" name="id" value="'.$row["id"].'">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteNews"><i class="far fa-trash-alt"></i></button>
                                                    <button type="submit" class="btn btn-warning btn-sm" name="openEditForm"><i class="far fa-edit"></i></button>
                                                </div>
                                            </form>';
                                    echo     '</td>';
                                    echo '</tr>';
                                }
                            ?>
                            
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="basic-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>Write some news</h2>
                <p>Let people know what is going on right now. Your Text will appear on the frontpage!</p>
                <p>You should avoid any coloring and sizing since it gets overwritten with the default style of the page.</p>
                <p>Feel free to add a picture to your message. It will appear in the default news image area on the home page.</p>
            </div>
            <div class="col-md-7">
                <h2> News</h2>
                <form method="post" action="/admin/news" autocomplete="off">
                    <input type="hidden" name="actionType" value="1">
                    <input type="hidden" name="userId" value="<?php echo Session::get('userid') ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" id="titel" name="title" placeholder="Titel">
                    </div>
                    <div class="form-group">
                        <label for="upload">Upload lead image</label>
                        <input type="file" class="form-control-file" id="upload">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="text" name="text" rows="15"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="createNews">Post News</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#news-list').DataTable();
} );
</script>

<script>
var textarea2 = document.getElementById('textChange');
sceditor.create(textarea2, {
	format: 'xhtml',
	style: '<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/themes/content/default.min.css'
});

var instance = sceditor.instance(textarea2);
instance.insert('<?php echo isset($ChangeRows["text"]) ? $ChangeRows["text"] : ""; ?>');
</script>

<?php include 'content/footer.cont.php'; ?>


<?php
// change news from start page
if (isset($_POST['openEditForm']))
{
    echo 'openEditForm called';
    $pg = "'page'";
    echo '<script> overlayOn('.$pg.') </script>';
}
?>
