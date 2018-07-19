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

    if (isset($_POST['btn-signin']))
	{
		$userName = $_POST['userName'];
		$userPassword = $_POST['userPass'];
        
        $userNameError = $accDB->checkName($userName, false);
        $userPassError = $accDB->checkCorrectPassword($userName, $userPassword);
        
        if (empty($userNameError) && empty($userPassError))
        {
            $errLoginTyp = "success";
            Session::set('userid', $accDB->getIdForAccountName($userName));
            Session::set('name', $userName);
        }
        else
        {
            $errLoginTyp = "danger";
            $errLoginMSG = "Something went wrong, try again later...";	
        }
    }

    // register
    $name = "";
    $email = "";
    $pass = "";
    
    $nameError = "";
    $emailError = "";
    $passError = "";

	if (isset($_POST['btn-signup']))
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$pass = $_POST['pass'];
		
        $nameError = $accDB->checkName($name, true);
        $emailError = $accDB->checkEMail($email);
		$passError = $accDB->checkPassword($pass);

		if(empty($emailError) && empty($nameError) && empty($passError))
		{
            $res = $accDB->createNewAccount($name, $pass, $email);
			if ($res)
			{
				$errTyp = "success";
				$errMSG = "Successfully registered, you may login now";
				unset($name);
				unset($email);
				unset($pass);
			}
			else
			{
				$errTyp = "danger";
				$errMSG = "Something went wrong, try again later...";	
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
        Welcome, Guest. Please <button type="button" class="btn btn-success btn-xs" onclick="loginOn()">Login</button> or <button type="button" class="btn btn-success btn-xs" onclick="registerOn()">Register</button>
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
        <h2>Welcome to this page!</h2>
    </div>
    <!-- new place -->
    <div id="overlay-login" onclick="loginOff()">
        <div id="login">
            <div id="login-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
             <div class="form-group">
                <h2 class="">Login</h2>
             </div>
             <div class="form-group">
                <hr />
             </div>
             <?php
                if (isset($errLoginMSG))
                {
                ?>
             <div class="form-group">
                <div class="alert alert-<?php echo ($errLoginTyp=="success") ? "success" : $errLoginTyp; ?>">
                   <span class="fa fa-info" aria-hidden="true"></span> <?php echo $errLoginMSG; ?>
                </div>
             </div>
             <?php
                }
                ?>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-user" aria-hidden="true"></span></span>
                   <input type="text" name="userName" class="form-control" placeholder="Enter Name" maxlength="50" />
                </div>
                <span class="text-danger"><?php echo $userNameError; ?></span>
             </div>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-key" aria-hidden="true"></span></span>
                   <input type="password" name="userPass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $userPassError; ?></span>
             </div>
             <div class="form-group">
                <hr />
             </div>
             <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-signin">Sign In</button>
             </div>
             <div class="form-group">
                <hr />
             </div>
          </form>
        </div>
            If you need an account, please <button type="button" class="btn btn-success btn-xs" onclick="loginOff;registerOn()()">Register</button>
        </div>
    </div>
    <div id="overlay-register" onclick="registerOff()">
        <div id="register">
            <div id="register-form">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
             <div class="form-group">
                <h2 class="">Account Registration</h2>
             </div>
             <div class="form-group">
                <hr />
             </div>
             <?php
                if (isset($errMSG))
                {
                ?>
             <div class="form-group">
                <div class="alert alert-<?php echo ($errTyp=="success") ? "success" : $errTyp; ?>">
                   <span class="fa fa-info" aria-hidden="true"></span> <?php echo $errMSG; ?>
                </div>
             </div>
             <?php
                }
                ?>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-user" aria-hidden="true"></span></span>
                   <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" />
                </div>
                <span class="text-danger"><?php echo $nameError; ?></span>
             </div>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-envelope" aria-hidden="true"></span></span>
                   <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" />
                </div>
                <span class="text-danger"><?php echo $emailError; ?></span>
             </div>
             <div class="form-group">
                <div class="input-group">
                   <span class="input-group-addon"><span class="fa fa-key" aria-hidden="true"></span></span>
                   <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                </div>
                <span class="text-danger"><?php echo $passError; ?></span>
             </div>
             <div class="form-group">
                <hr />
             </div>
             <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
             </div>
             <div class="form-group">
                <hr />
             </div>
          </form>
            </div>
            If you already have an account, please <button type="button" class="btn btn-success btn-xs" onclick="registerOff();loginOn()">Login</button>
        </div>
    </div>
</div>
    
<script>

function loginOn() {
    document.getElementById("overlay-login").style.display = "block";
}

function loginOff() {
    document.getElementById("overlay-login").style.display = "none";
}
        
function registerOn() {
    document.getElementById("overlay-register").style.display = "block";
}

function registerOff() {
    document.getElementById("overlay-register").style.display = "none";
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