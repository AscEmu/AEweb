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
</head>
<body>
<div class="container">
    <!-- new place -->
    <?php
       if (!Session::get('userid'))
       {
       ?>
    <div class="col-md-4">
    </div>
    <div class="col-md-4">
        <div id="login">
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
            If you need an account, please <button type="button" class="btn btn-success btn-xs" onclick="toggleRegisterLogin()">Register</button>
        </div>
        <div id="register" style="display:none">
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
            If you already have an account, please <button type="button" class="btn btn-success btn-xs" onclick="toggleRegisterLogin()">Login</button>
        </div>
    </div>
    <div class="col-md-4">
    </div>
    <?php
    }
    else
    {
    ?>
    Welcome <?php echo Session::get('userid'); ?>, <a href="logout.php">Logout</a>
    <?php
    }
    ?>
</div>
    
<script>
function toggleRegisterLogin() {
    var loginId = document.getElementById("login");
    var registerId = document.getElementById("register");
    if (loginId.style.display == "none")
    {
        loginId.style.display = "block";
        registerId.style.display = "none";
    }
    else
    {
        loginId.style.display = "none";
        registerId.style.display = "block";
    }
}
</script>
</body>
</html>
<?php ob_end_flush(); ?>