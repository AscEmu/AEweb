
<?php include 'content/head.tmp.php'; ?>

<div class="container">
    <div class="row">
        <div class="col-lg-12">
<?php
// create realm
if (isset($_POST['createRealm']))
{
    $id = $_POST['realmId'];
    
    // web DB
    $name = $_POST['name'];
    $description = $_POST['description'];
    $version = $_POST['version'];
    
    $host = $_POST['db_host'];
    $user = $_POST['db_user'];
    $password = $_POST['db_pass'];
    $database = $_POST['db_name'];
    
    $realmQuery = $webDB->setRealmData($id, $host, $user, $password, $database, $name, $description, $version);
    if (!$realmQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Realm not created in web database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Realm created in web database.
            </div>';
    }
    
    // acc DB
    $logonPass = $_POST['logon_pass'];
    
    $realmAccQuery = $accDB->setRealmData($id, $logonPass);
    if (!$realmAccQuery)
    {
        echo $id .',' .$logonPass;
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Realm not created in acc database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Realm created in acc database.
            </div>';
    }
}

// load data in case of a change request
if (isset($_POST['openEditForm']))
{
    $realmId = $_POST['id'];
    
    $realmsChangeQuery = $webDB->getRealmInfoFromDB($realmId);
    if (!$realmsChangeQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> No data found inside web tables for realm id '.$realmId.'</div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Realm '.$realmId.' loaded.
            </div>';
    }
    
    $realmsChangeAccQuery = $accDB->getRealmDataForId($realmId);
    if (!$realmsChangeAccQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Tried to load realm with id '.$realmId.'</div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Realm '.$realmId.' loaded.
            </div>';
    }
}

// change realm
if (isset($_POST['changeRealm']))
{
    $id = $_POST['CH_realmId'];
    
    echo $id;
    
    // web DB
    $name = $_POST['CH_name'];
    $description = $_POST['CH_description'];
    $version = $_POST['CH_version'];
    
    $host = $_POST['CH_db_host'];
    $user = $_POST['CH_db_user'];
    $password = $_POST['CH_db_pass'];
    $database = $_POST['CH_db_name'];
    
    $realmQuery = $webDB->setRealmData($id, $host, $user, $password, $database, $name, $description, $version);
    if (!$realmQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Realm not created in web database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Realm created in web database.
            </div>';
    }
    
    // acc DB
    $logonPass = $_POST['CH_logon_pass'];
    
    $realmAccQuery = $accDB->setRealmData($id, $logonPass);
    if (!$realmAccQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Realm not created in acc database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Realm created in acc database.
            </div>';
    }
}

// delete realm
if (isset($_POST['deleteRealm']))
{
    $realmId = $_POST['id'];
    
    $realmsQuery = $webDB->deleteRealmById($realmId);
    $logonRealmQuery = $accDB->deleteRealmById($realmId);
    if (!$realmsQuery || !$logonRealmQuery)
    {
        echo '<div class="alert alert-danger alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Error!</strong> Realm not deleted from database.
            </div>';
    }
    else
    {
        echo '<div class="alert alert-success alert-dismissible">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
              <strong>Success!</strong> Realm deleted from database.
            </div>';
    }
}

$availableRealms = $accDB->getAvailableRealms();

$realmsCount = $availableRealms->num_rows;

while($row = $availableRealms->fetch_array())
{
   $rows[] = $row;
}

?>

<!-- hidden page form start -->
    <div id="overlay-page" onclick="overlayOff('page')">
        <div id="page">
            <div id="page-form">
                <form method="post" action="/admin/realms" autocomplete="off">
                    <input type="hidden" name="CH_realmId" value="<?php echo isset($realmsChangeAccQuery["id"]) ? $realmsChangeAccQuery["id"] : 0; ?>">
                    <div class="form-group">
                        <label for="CH_name">Realm Name</label>
                        <input type="text" class="form-control" id="CH_name" size="100" name="CH_name" value="<?php echo isset($realmsChangeQuery["name"]) ? $realmsChangeQuery["name"] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="CH_description">Description</label>
                        <input type="text" class="form-control" id="CH_description" name="CH_description"  value="<?php echo isset($realmsChangeQuery["description"]) ? $realmsChangeQuery["description"] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="CH_description">Description</label>
                        <select name="CH_version">
                            <option value=""></option>
                            <option value="<?php echo isset($realmsChangeQuery["version"]) ? $realmsChangeQuery["version"] : ""; ?>"> Selected <?php echo isset($realmsChangeQuery["version"]) ? $realmsChangeQuery["version"] : ""; ?></option>
                            <option value="1.12.1">1.12.1</option>
                            <option value="2.4.3">2.4.3</option>
                            <option value="3.3.5">3.3.5</option>
                            <option value="4.3.4">4.3.4</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="CH_db_host">Char DB Host</label>
                        <input type="text" class="form-control" id="CH_db_host" name="CH_db_host" value="<?php echo isset($realmsChangeQuery["host"]) ? $realmsChangeQuery["host"] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="CH_db_user">Char DB User</label>
                        <input type="text" class="form-control" id="CH_db_user" name="CH_db_user" value="<?php echo isset($realmsChangeQuery["user"]) ? $realmsChangeQuery["user"] : ""; ?>">
                    </div>
                    <div class="form-group">
                        <label for="CH_db_pass">Char DB Password</label>
                        <input type="text" class="form-control" id="CH_db_pass" name="CH_db_pass">
                    </div>
                    <div class="form-group">
                        <label for="CH_db_name">Char DB Database</label>
                        <input type="text" class="form-control" id="CH_db_name" name="CH_db_name" value="<?php echo isset($realmsChangeQuery["database"]) ? $realmsChangeQuery["database"] : ""; ?>">
                    </div>
                    <hr>
                    <div class="form-group">
                        <label for="CH_logon_pass">Char DB Logon Password</label>
                        <input type="text" class="form-control" id="CH_logon_pass" name="CH_logon_pass" value="<?php echo isset($realmsChangeAccQuery["password"]) ? $realmsChangeAccQuery["password"] : ""; ?>">
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="changeRealm">Update Realm info</button>
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
                <h2><i class="fas fa-server"></i> Realm Servers</h2>
                <table id="news-list" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>name</th>
                            <th>description</th>
                            <th>version</th>
                            <th>action</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                foreach($rows as $row)
                                {
                                    $pg = "'page'";
                                    $realmsQueryFields = $webDB->getRealmInfoFromDB($row["id"]);
                                    echo '<tr>';
                                    echo     '<td>'.$row["id"].'</td>';
                                    echo     '<td>'.$realmsQueryFields["name"].'</td>';
                                    echo     '<td>'.(is_null($realmsQueryFields["description"]) ? 'SET REALM INFO!' : $realmsQueryFields["description"]).'</td>';
                                    echo     '<td>'.$realmsQueryFields["version"].'</td>';
                                    echo     '<td>';
                                    echo     '<form method="post" action="/admin/realms" autocomplete="off">
                                                <input type="hidden" name="id" value="'.$row["id"].'">
                                                <div class="form-group">
                                                    <button type="submit" class="btn btn-danger btn-sm" name="deleteRealm"><i class="far fa-trash-alt"></i></button>
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
                <h2>Add Realm Server</h2>
                <p>Add a new Realm Server to the logon DB.</p>
            </div>
            <div class="col-md-7">
                <h2> Realm</h2>
                <form method="post" action="/admin/realms" autocomplete="off">
                    <input type="hidden" name="actionType" value="1">
                    <input type="hidden" name="realmId" value="<?php echo $realmsCount + 1 ?>">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <select name="version">
                            <option value=""></option>
                            <option value="1.12.1">1.12.1</option>
                            <option value="2.4.3">2.4.3</option>
                            <option value="3.3.5">3.3.5</option>
                            <option value="4.3.4">4.3.4</option>
                        </select>
                    </div>
                    <hr>
                    <div class="form-group">
                        <input type="text" class="form-control" id="db_host" name="db_host" placeholder="Char DB Host e.g. 127.0.0.1">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="db_user" name="db_user" placeholder="Char DB User e.g. root">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="db_pass" name="db_pass" placeholder="Char DB Password e.g. rthjFTfutf!772">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="db_name" name="db_name" placeholder="Char DB Name e.g. ascemu_char">
                    </div>
                    <hr>
                    <div class="form-group">
                        <input type="text" class="form-control" id="logon_pass" name="logon_pass" placeholder="Logon Password e.g. change_me_logon">
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="createRealm">Add Realm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

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
