<?php

?>

<?php include 'content/header.cont.php'; ?>

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
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
