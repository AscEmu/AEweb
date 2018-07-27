<?php include 'content/header.cont.php'; ?>

<?php include_once 'include/uploads.inc.php'; ?>

<?php

if (isset($_POST["uploadAvatar"]))
{
    $uploadDir = "uploads/avatars/";
    
    $isUploaded = Upload::uploadFile($_FILES, $uploadDir, Config\Hosting::maxUploadSize, true);
    
    $oldAvatar = $webDB->getAvatar(Session::get('userid'));

    $result = $webDB->setNewAvatar(Session::get('userid'), Session::get('userid').'_'.$_FILES["uploadFile"]["name"]);
    if ($result)
    {
        if ($oldAvatar != "default.jpg")
            Upload::removeFile($uploadDir, $oldAvatar);
    }
}

?>

<?php include 'content/userNavigation.cont.php'; ?>
<?php include 'content/navigation.cont.php'; ?>
<?php include 'content/errorBox.cont.php'; ?>

<!-- hidden page form start -->
    <div id="overlay-page" onclick="overlayOff('page')">
        <div id="page">
            <div id="page-form">
                <form method="post" action="home" enctype="multipart/form-data">
                    <h3><i class="fas fa-id-card-alt"></i> Upload an Avatar</h3>
                    <p>Maximum size of an avatar ist <?php echo Config\Hosting::maxUploadSize / 1000 ?> KB.</p>
                    <p>The allowed formats are: .jpg, .png, .jpeg, and .gif.</p>
                    <hr>
                    <div class="form-group">
                        <label for="uploadFile">Upload Image</label>
                        <input type="file" class="form-control-file" name="uploadFile" id="uploadFile">
                    </div>
                    <hr>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="uploadAvatar">Upload Avatar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<!-- hidden page form ends -->

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-2">
                <img class="image-lg-right" src="<?php echo Config\Hosting::baseURL ?>uploads/avatars/<?php echo $userFields['avatar'] ?>" width="150px" height="150px" style="border:3px solid grey; vertical-align: middle;" >
            </div>
            <div class="col-md-6">
                <table width="100%">
                    <tbody>
                        <tr>
                            <td>Displayed Name</td>
                            <td><?php echo $userFields['displayName'] ?></td>
                        </tr>
                        <tr>
                            <td>Join Date</td>
                            <td><?php $date=date_create($accountFields['joindate']); echo date_format($date,"Y/m/d H:i:s"); ?></td>
                        </tr>
                        <tr>
                            <td>Account Name</td>
                            <td><?php echo $accountFields['acc_name'] ?></td>
                        </tr>
                        <tr>
                            <td>Last Login</td>
                            <td><?php $date=date_create($accountFields['lastlogin']); echo date_format($date,"Y/m/d H:i:s"); ?></td>
                        </tr>
                        <tr>
                            <td>E-Mail</td>
                            <td><?php echo $accountFields['email'] ?></td>
                        </tr>
                        <tr>
                            <td>Account Flags</td>
                            <td><?php echo $accountFields['flags'] ?></td>
                        </tr>
                    </tbody>
                </table>
                <hr>
            </div>
            <div class="col-md-4">
                <p>Add info edit options here!</p>
            </div>
        </div>
    </div>
</div>
<div class="basic-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-success btn-lg" onclick="overlayOn('page')"><i class="fas fa-id-card-alt"></i> Upload new avatar</button>
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
