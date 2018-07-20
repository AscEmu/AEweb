<?php
	ob_start();
    session_start();
	include_once 'background.php';
    include_once 'include/database.inc.php';
    include_once 'include/accountDB.inc.php';
    include_once 'include/session.inc.php';
    include_once 'include/webDB.inc.php';

    $accDB = new AccountDB();
    $webDB = new WebDB();

    // login
    $userName = "";
    $userPassword = "";

    $userNameError = "";
    $userPassError = "";

    $hasLoginError = false;

    if (isset($_POST['btn-signin']))
	{
		$userName = $_POST['userName'];
		$userPassword = $_POST['userPass'];
        
        $userNameError = $accDB->checkName($userName, false);
        $userPassError = $accDB->checkCorrectPassword($userName, $userPassword);
        
        if (!empty($userNameError) || !empty($userPassError))
            $hasLoginError = true;
        
        if (!$hasLoginError)
        {
            Session::set('userid', $accDB->getIdForAccountName($userName));
            Session::set('name', $userName);
        }
    }

    // register
    $name = "";
    $email = "";
    $pass = "";
    
    $nameError = "";
    $displayName = "";
    $emailError = "";
    $passError = "";

    $errMSG = "";

    $hasRegisterError = false;

	if (isset($_POST['btn-signup']))
	{
		$name = $_POST['name'];
        $displayName = $_POST['displayName'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		
        $nameError = $accDB->checkName($name, true);
        if ($displayName == $name)
            $nameError = "The Display Name can not be the same as your account name!";
        
        if (empty($displayName))
            $nameError = "The have to choose a Display Name!";
        
        $emailError = $accDB->checkEMail($email);
		$passError = $accDB->checkPassword($pass);
        
        if(!empty($emailError) || !empty($nameError) || !empty($passError))
            $hasRegisterError = true;

		if(!$hasRegisterError)
		{
            $res = $accDB->createNewAccount($name, $pass, $email);
			if ($res)
			{
                $id = $accDB->getIdForAccountName($name);
                $res2 = $webDB->createWebData($id, $displayName);
                if ($res2)
                {
                    $errMSG = "Successfully registered, you may login now";
				    unset($name);
				    unset($email);
				    unset($pass);
                    unset($displayName);
                }
                else
                {
                    $hasRegisterError = true;
                    $errMSG = "The account was not created due to web database issues!";
                    //fall back if web user creation fails
                    $accDB->deleteAccountById($id);
                }
			}
		}
	}

    include_once 'configs/web.conf.php';
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html">
<meta charset="<?php echo Config\Meta::charset ?>">
<meta name="description" content="<?php echo Config\Meta::description ?>">
<meta name="keywords" content="<?php echo Config\Meta::keywords ?>">
<meta name="author" content="<?php echo Config\Meta::author ?>">
<meta name="viewport" content="<?php echo Config\Meta::viewport ?>">
    
<title><?php echo Config\Info::siteName ?></title>
    
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome-4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>

<div class="user-bar">
    <div class="container">
    <?php
        if (!Session::get('userid'))
        {
    ?>
        Welcome, Guest. Please <button type="button" class="btn btn-success btn-xs" onclick="overlayOn('login')">Login</button> or <button type="button" class="btn btn-success btn-xs" onclick="overlayOn('register')">Register</button>
    <?php
        }
        else
        {
            $userFields = $webDB->getAllUserDataForAccount(Session::get('userid'));
            if (!empty($userFields))
            {
    ?>
        <p style="text-align:left;">
            <img src="uploads/avatars/<?php echo $userFields['avatar'] ?>" width="auto" height="100%" style="border:3px solid grey" > Welcome <?php echo $userFields['displayName'] ?>
            <span style="float:right;"><a href="logout.php" class="btn btn-danger btn-xs" role="button" aria-pressed="true"><i class="fa fa-power-off"></i> Logout</a></span>
        </p>
    <?php
            }
        }
    ?>
    </div>
</div>
    
<div class="container main">
    <div class="col-md-12">
        <!-- print error if set -->
        <?php include 'content/errorForm.content.php';?>
        
        <h2>Welcome to this page!</h2>
    </div>
    <!-- load forms -->
    <?php include 'content/loginForm.content.php';?>
    <?php include 'content/registerForm.content.php';?>
    
    <div class="col-md-12">
        Some Content...
    </div>
</div>
    
<footer>
    <div class="container">
        <div class="col-md-4">
            <h3><?php echo Config\Info::siteName ?></h3>
            <p><?php echo Config\Info::siteSlogan ?></p>
            <p>&copy; <?php echo Config\Info::siteName ?> | <?php echo Config\Info::foundedInYear != date("Y") ? Config\Info::foundedInYear."-".date("Y") : Config\Info::foundedInYear ?></p>
        </div>
        <div class="col-md-4">
            Some Text to pretend here is some content.
        </div>
        <div class="col-md-4">
            Home | Rules | Status (it is fake! Do not press it!)
        </div>
    </div>
</footer>
    
<script>

function overlayOn(name) {
    document.getElementById("overlay-"+name).style.display = "block";
}

function overlayOff(name) {
    document.getElementById("overlay-"+name).style.display = "none";
}
        
// ignore onclick event in this div ids
$(document).ready(function() {

    $('#register-form').click(function(e) {
        e.stopPropagation();
    });
    
    $('#login-form').click(function(e) {
        e.stopPropagation();
    });

});
</script>
</body>
</html>
<?php ob_end_flush(); ?>