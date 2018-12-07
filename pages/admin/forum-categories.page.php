
<?php include 'content/head.tmp.php'; ?>


<div class="container">
    <div class="row">
        <div class="col-lg-12">
<?php

// add category
if (isset($_POST['createCategory']))
{
    $userId = $_POST['userId'];
    $title = $_POST['title'];
    $text = $_POST['text'];
    
    $categoryQuery = $webDB->addCategory($title, $text);
    if (!$categoryQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Category not created in database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Category created in database.
            </div>';
    }
}

// load data in case of a change request
if (isset($_POST['openEditForm']))
{
    $categoryId = $_POST['id'];
    
    $categoryQuery = $webDB->getCategoryById($categoryId);
    if (!$categoryQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Tried to load Category with id '.$categoryId.'</div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Category loaded.
            </div>';
    }
    
    while($row = $categoryQuery->fetch_array())
    {
       $ChangeRows = $row;
    }
}

// change Category in admin/Category page
if (isset($_POST['editCategory']))
{
    $userId = $_POST['userId'];
    $title = $_POST['titelChange'];
    $text = $_POST['textChange'];
    $id = $_POST['id'];
    
    $categoryQuery = $webDB->updateCategory($title, $text, $id);
    if (!$categoryQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Category not updated in database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Category updated in database.
            </div>';
    }
}

// delete Category
if (isset($_POST['deleteCategory']))
{
    $categoryId = $_POST['id'];
    
    $categoryQuery = $webDB->deleteCategoryById($categoryId);
    if (!$categoryQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Category not deleted from database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Category deleted from database.
            </div>';
    }
}

// get Category from db
$categories = $webDB->getCategories();
while($row = $categories->fetch_array())
{
   $rows[] = $row;
}

?>

<!-- hidden page form start -->
    <div id="overlay-page" onclick="overlayOff('page')">
        <div id="page">
            <div id="page-form">
            <form method="post" action="/admin/forum-categories" autocomplete="off">
                <input type="hidden" name="actionType" value="2">
                <input type="hidden" name="id" value="<?php echo isset($ChangeRows["id"]) ? $ChangeRows["id"] : 0; ?>">
                    <input type="hidden" name="userId" value="<?php echo Session::get('userid') ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" id="titelChange" name="titelChange" value="<?php echo isset($ChangeRows["name"]) ? $ChangeRows["name"] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="textChange" name="textChange" rows="15" ></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="editCategory">Update Category</button>
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
                <h2><i class="fa fa-clipboard-list"></i> Forum Categories</h2>
                <table id="category-list" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>description</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                foreach($rows as $row)
                                {
                                    $pg = "'page'";
                                    $text = isset($row["name"]) ? $row["name"] : "";
                                    echo '<tr>';
                                    echo     '<td>'.$row["id"].'</td>';
                                    echo     '<td>'.$row["name"].'</td>';
                                    echo     '<td>'.$row["description"].'</td>';
                                    echo     '<td>';
                                    echo     '<form method="post" action="/admin/forum-categories" autocomplete="off">
                                                <input type="hidden" name="id" value="'.$row["id"].'">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteCategory"><i class="far fa-trash-alt"></i></button>
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
                <h2>Add a category</h2>
                <p>Give your users room to categorise topics.</p>
            </div>
            <div class="col-md-7">
                <h2> Category</h2>
                <form method="post" action="/admin/forum-categories" autocomplete="off">
                    <input type="hidden" name="actionType" value="1">
                    <input type="hidden" name="userId" value="<?php echo Session::get('userid') ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" id="titel" name="title" placeholder="Titel">
                    </div>
                    <div class="form-group">
                        <textarea class="form-control" id="text" name="text" rows="15"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="createCategory">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#category-list').DataTable();
} );
</script>

<script>
var textarea2 = document.getElementById('textChange');
sceditor.create(textarea2, {
	format: 'bbcode',
	style: '<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/themes/content/default.min.css'
});

var instance = sceditor.instance(textarea2);
instance.insert('<?php echo isset($ChangeRows["description"]) ? html_entity_decode($ChangeRows["description"]) : ""; ?>');
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
