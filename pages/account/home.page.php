<?php include 'content/header.cont.php'; ?>

<?php

if(isset($_POST["uploadAvatar"]))
{
    $uploadDir = "uploads/avatars/";
    $uploadFirAndFileName = $uploadDir . Session::get('userid').'_'.basename($_FILES["fileToUpload"]["name"]);
    $isUploaded = true;
    $imageFileType = strtolower(pathinfo($uploadFirAndFileName,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false)
        $isUploaded = true;
    else
        $isUploaded = false;
    
    if (file_exists($uploadFirAndFileName))
        $isUploaded = false;

    if ($_FILES["fileToUpload"]["size"] > 500000)
        $isUploaded = false;

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" )
        $isUploaded = false;
    
    // get current avatar
    $oldAvatar = $webDB->getAvatar(Session::get('userid'));

    if ($isUploaded)
    {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadFirAndFileName))
        {
            $result = $webDB->setNewAvatar(Session::get('userid'), Session::get('userid').'_'.$_FILES["fileToUpload"]["name"]);
            if ($result)
            {
                if ($oldAvatar != "default.jpg")
                    unlink($uploadDir . $oldAvatar);
                
                //header("Refresh:0");
            }
        }
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
                    <div class="form-group">
                        Select image to upload:
                        <label for="fileToUpload">Upload Image</label>
                        <input type="file" class="form-control-file" name="fileToUpload" id="fileToUpload">
                    </div>
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
                <button type="button" class="btn btn-success btn-lg" onclick="overlayOn('page')"><i class="fas fa-id-card-alt"></i> Change Image</button>
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
