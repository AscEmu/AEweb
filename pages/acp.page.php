<?php

?>

<?php include 'content/header.cont.php'; ?>

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <img src="uploads/avatars/<?php echo $userFields['avatar'] ?>" width="150px" height="150px" style="border:3px solid grey; vertical-align: middle;" >
                <p>Displayed Name: <?php echo $userFields['displayName'] ?></p>
                <p>Join Date: <?php $date=date_create($accountFields['joindate']); echo date_format($date,"Y/m/d H:i:s");  ?></p>
                <p>Account Name: <?php echo $accountFields['acc_name'] ?></p>
                <p>Last Login: <?php $date=date_create($accountFields['lastlogin']); echo date_format($date,"Y/m/d H:i:s"); ?></p>
                <p>E-Mail: <?php echo $accountFields['email'] ?></p>
                <p>Account Flags: <?php echo $accountFields['flags'] ?></p>
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
                Some Content...
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
