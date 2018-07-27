
<?php include 'content/head.tmp.php'; ?>

<?php include_once 'include/uploads.inc.php'; ?>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
<?php

// create slide
if (isset($_POST['createSlide']))
{
    $imageName = $_FILES["uploadFile"]["name"];
    $caption = $_POST['text'];
    $author = $_POST['author'];

    $slideQuery = $webDB->addSlideToDB($imageName, $caption, $author);
    if (!$slideQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Slide not added to table slideshow. Query failed.
            </div>';
    }
    else
    {
        $uploadDir = "uploads/slideshow/";
    
        $isUploaded = Upload::uploadFile($_FILES, $uploadDir, Config\Hosting::maxUploadSize);
    
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Slide added to database.
            </div>';
    }
}

// load data in case of a change request
if (isset($_POST['openEditForm']))
{
    $slideId = $_POST['id'];
    
    $slideQuery = $webDB->getSlideById($slideId);
    if (!$slideQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Tried to load slide with id '.$slideId.' from db - FAILED</div>';
    }
    
    while($row = $slideQuery->fetch_array())
    {
       $ChangeRows = $row;
    }
}

// change news in admin/news page
if (isset($_POST['editSlide']))
{
    $imageName = "";
    if (isset($_FILES))
        $imageName = $_FILES["uploadFile"]["name"];
    
    $caption = $_POST['textChange'];
    $author = $_POST['authorChange'];
    $id = $_POST['id'];

    $slideQuery = $webDB->updateSlideInDB($id, $imageName, $caption, $author);
    if (!$slideQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Slide not edited in table slideshow. Query failed.
            </div>';
    }
    else
    {
        if (isset($_FILES) && !empty($_FILES["uploadFile"]["name"]))
        {
            $uploadDir = "uploads/slideshow/";
    
            $isUploaded = Upload::uploadFile($_FILES, $uploadDir, Config\Hosting::maxUploadSize);
        }
    
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Slide edited in database.
            </div>';
    }
}

// delete slide
if (isset($_POST['deleteSlide']))
{
    $slideId = $_POST['id'];
    
    $slideQuery = $webDB->deleteSlideById($slideId);
    if (!$slideQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Slide not deleted from database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Slide deleted from database.
            </div>';
    }
}

// get slides from db
$news = $webDB->getAllSlides();
while($row = $news->fetch_array())
{
   $rows[] = $row;
}

?>

<!-- hidden page form start -->
    <div id="overlay-page" onclick="overlayOff('page')">
        <div id="page">
            <div id="page-form">
                <form method="post" action="/admin/slideshow" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $_POST['id'] ?>">
                    <div class="form-group">
                        <label for="uploadFile">Upload New Image</label>
                        <input type="file" class="form-control-file" name="uploadFile" id="uploadFile">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="authorChange" name="authorChange" placeholder="Author">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="textChange" name="textChange" rows="15"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="editSlide">Add Slide</button>
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
                <h2><i class="far fa-images"></i> Slides</h2>
                <table id="news-list" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Caption</th>
                            <th>Author</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                foreach($rows as $row)
                                {
                                    $pg = "'page'";
                                    $text = isset($row["text"]) ? $row["text"] : "";
                                    echo '<tr>';
                                    echo     '<td>'.$row["sort"].'</td>';
                                    echo     '<td><img src="/uploads/slideshow/'.$row["imageName"].'" height="80px" width="auto"></td>';
                                    echo     '<td>'.BBCodeParser::toHtml($row["caption"]).'</td>';
                                    echo     '<td>'.$row["author"].'</td>';
                                    echo     '<td>';
                                    echo     '<form method="post" action="/admin/slideshow" autocomplete="off">
                                                <input type="hidden" name="id" value="'.$row["sort"].'">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteSlide"><i class="far fa-trash-alt"></i></button>
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
                <h2>Add a slide</h2>
                <p>You can simply add new slides to your slideshow with this form.</p>
                <p>A slide should always contain a short caption and the author (if the author is empty it will be you).</p>
                <p>The last four slides will be shown on the front page. Delete unused slides.</p>
            </div>
            <div class="col-md-7">
                <h2> Slide</h2>
                <form method="post" action="/admin/slideshow" enctype="multipart/form-data">
                    <input type="hidden" name="userId" value="<?php echo Session::get('userid') ?>">
                    <div class="form-group">
                        <label for="uploadFile">Upload Image</label>
                        <input type="file" class="form-control-file" name="uploadFile" id="uploadFile">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="author" name="author" placeholder="Author">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="text" name="text" rows="15"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="createSlide">Add Slide</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
var textarea2 = document.getElementById('textChange');
sceditor.create(textarea2, {
	format: 'bbcode',
	style: '<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/themes/content/default.min.css'
});

var instance = sceditor.instance(textarea2);
instance.insert('<?php echo isset($ChangeRows["caption"]) ? $webDB->escapeString($ChangeRows["caption"]) : ""; ?>');

document.getElementById("authorChange").value = "<?php echo isset($ChangeRows["author"]) ? $ChangeRows["author"] : ""; ?>";
document.getElementById("uploadFile").value = "<?php echo isset($ChangeRows["imageName"]) ? $ChangeRows["imageName"] : ""; ?>";
</script>

<?php include 'content/footer.cont.php'; ?>


<?php
// call overlay in case of opening edit form (this is at the end of the file since the form gets constructed at the beginning and set to be hidden)
if (isset($_POST['openEditForm']))
{
    echo '';
    $pg = "'page'";
    echo '<script> overlayOn('.$pg.') </script>';
}
?>
