
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
    $type = $_POST['type'];
    
    $parentId = 0;
    
    if ($type == 0)
        $parentId = $_POST['parentIdForCategory'];
    else
        $parentId = $_POST['parentIdForForum'];
    
    $categoryQuery = $webDB->addCategory($parentId, $title, $text, $type);
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
    $type = $_POST['typeC'];
    
    $parentId = 0;
    
    if ($type == 0)
        $parentId = $_POST['parentIdForCategoryC'];
    else
        $parentId = $_POST['parentIdForForumC'];
    
    $categoryQuery = $webDB->updateCategory($parentId, $title, $text, $type, $id);
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
$rows = [];
$categories = $webDB->getCategories();
while($row = $categories->fetch_array())
{
   $rows[] = $row;
}

// get available Categories for subcategory
$parentCategories = $webDB->getAvailableCategoriesForSubCategory();
while($row = $parentCategories->fetch_array())
{
   $categoryRows[] = $row;
}

// get available Categories for forums
$parentCategoriesForum = $webDB->getAvailableCategoriesForForum();
while($row = $parentCategoriesForum->fetch_array())
{
   $forumCategoryRows[] = $row;
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
                    <br>
                    <!-- type -->
                    <input type="hidden" name="typeC" value="<?php echo isset($ChangeRows["type"]) ? $ChangeRows["type"]: 0; ?>">
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="_categoryC" name="typeCC" value="0" disabled <?php echo isset($ChangeRows["type"]) ? $ChangeRows["type"] == 0 ? "checked" : "" : ""; ?>>
                        <label class="custom-control-label" for="_categoryC">Category</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="_forumC" name="typeCC" value="1" disabled <?php echo isset($ChangeRows["type"]) ? $ChangeRows["type"] == 1 ? "checked" : "" : ""; ?>>
                        <label class="custom-control-label" for="_forumC">Forum</label>
                    </div>
                    <br><br>
                    <!-- parent list -->
                    <?php 
                        if (isset($ChangeRows["type"]) && $ChangeRows["type"] == 0)
                        {
                    ?>
                            <div class="form-group" id="_forCategoryC">
                                <label for="parentCatC">Select parent category for category</label>
                                <select class="form-control" name="parentIdForCategoryC" id="parentCatC">
                                    <?php
                                        echo '<option value="0"></option>';
                                        foreach($categoryRows as $row)
                                        {
                                            if (isset($ChangeRows["parentId"]) && $ChangeRows["parentId"] != 0 && $ChangeRows["parentId"] == $row["id"])
                                            {
                                                echo '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
                                            }
                                            else
                                            {
                                                echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                    <?php 
                        }
                        else
                        {
                    ?>
                            <div class="form-group" id="_forForumC">
                                <label for="parentForumC">Select parent category for forum</label>
                                <select class="form-control" name="parentIdForForumC" id="parentForumC">
                                    <?php
                                        foreach($forumCategoryRows as $row)
                                        {
                                            if (isset($ChangeRows["parentId"]) && $ChangeRows["parentId"] != 0 && $ChangeRows["parentId"] == $row["id"])
                                            {
                                                echo '<option value="'.$row["id"].'" selected>'.$row["name"].'</option>';
                                            }
                                            else
                                            {
                                                echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                    <?php
                        }
                    ?>
                    <br>
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
                <h2><i class="fa fa-clipboard-list"></i> Forums/Categories</h2>
                <?php
                    if (sizeof($rows) > 0)
                    {
                ?>
                <table id="category-list" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>parentId</th>
                            <th>name</th>
                            <th>description</th>
                            <th>type</th>
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
                                        echo     '<td>'.$row["parentId"].'</td>';
                                        echo     '<td>'.$row["name"].'</td>';
                                        echo     '<td>'.$row["description"].'</td>';
                                        if ($row["type"] == 0)
                                            echo     '<td>category</td>';
                                        else
                                            echo     '<td>forum</td>';
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
            <?php
                    }
                    else
                    {
                        echo 'No Forums or Categories found!';
                    }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="basic-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h2>Add a category/forum</h2>
                <p>Every Forum needs a parent category.</p>
                <p>Only a Forum can hold topics.</p>
                <p>Every category can hold sub categories.</p>
                <p>Sub categories can not hold more sub categories.</p>
            </div>
            <div class="col-md-7">
                <h2> Category/Forum</h2>
                <form method="post" action="/admin/forum-categories" autocomplete="off">
                    <input type="hidden" name="actionType" value="1">
                    <input type="hidden" name="userId" value="<?php echo Session::get('userid') ?>">
                    <br>
                    <!-- type -->
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="_category" name="type" value="0">
                        <label class="custom-control-label" for="_category">Category</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio" class="custom-control-input" id="_forum" name="type" value="1" checked>
                        <label class="custom-control-label" for="_forum">Forum</label>
                    </div>
                    <br><br>
                    <!-- parent list -->
                    <div class="form-group" id="_forCategory">
                        <label for="parentCat">Select parent category for category</label>
                        <select class="form-control" name="parentIdForCategory" id="parentCat">
                            <?php
                                echo '<option value="0"></option>';
                                foreach($categoryRows as $row)
                                {
                                    echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" id="_forForum">
                        <label for="parentForum">Select parent category for forum</label>
                        <select class="form-control" name="parentIdForForum" id="parentForum">
                            <?php
                                foreach($forumCategoryRows as $row)
                                {
                                    echo '<option value="'.$row["id"].'">'.$row["name"].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <br>
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

<script>
var radios = document.getElementsByName("type");
var forCat =  document.getElementById("_forCategory");
var forForum =  document.getElementById("_forForum");

forCat.style.display = 'none';
forForum.style.display = 'block';

for(var i = 0; i < radios.length; i++) {
    radios[i].onclick = function() {
        var val = this.value;
        if(val == '0'){
            forCat.style.display = 'block';
            forForum.style.display = 'none';
        }
        else if(val == '1'){
             forCat.style.display = 'none';
             forForum.style.display = 'block';
        }    
            
    }
}
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
