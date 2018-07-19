<?php
	ob_start();
    session_start();
	include_once 'background.php';
    include_once 'include/database.inc.php';
    include_once 'include/accountDB.inc.php';
    include_once 'include/session.inc.php';

    $accDB = new AccountDB();

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
    $emailError = "";
    $passError = "";

    $errMSG = "";

    $hasRegisterError = false;

	if (isset($_POST['btn-signup']))
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		
        $nameError = $accDB->checkName($name, true);
        $emailError = $accDB->checkEMail($email);
		$passError = $accDB->checkPassword($pass);
        
        if(!empty($emailError) || !empty($nameError) || !empty($passError))
            $hasRegisterError = true;

		if(!$hasRegisterError)
		{
            $res = $accDB->createNewAccount($name, $pass, $email);
			if ($res)
			{
                $errMSG = "Successfully registered, you may login now";
				unset($name);
				unset($email);
				unset($pass);
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Simple Register</title>
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
    ?>
        <p style="text-align:left;">
            Welcome <?php echo Session::get('name'); ?>
            <span style="float:right;"><a href="logout.php" class="btn btn-danger btn-xs" role="button" aria-pressed="true"><i class="fa fa-power-off"></i> Logout</a></span>
        </p>
    <?php
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