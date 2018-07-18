<?php
	ob_start();
	include_once 'background.php';
    include_once 'include/database.inc.php';
    include_once 'include/accountDB.inc.php';

    $accDB = new AccountDB();
	$error = false;
    
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
		
		if (empty($name))
		{
			$error = true;
			$nameError = "Please enter an account name.";
		}
		else if (strlen($name) < 3)
		{
			$error = true;
			$nameError = "Name must have atleat 3 characters.";
		}
		else if (!preg_match("/^[a-zA-Z]+$/",$name))
		{
			$error = true;
			$nameError = "Name must contain alphabets and NO spaces.";
		}
		else
		{
			$count = $accDB->isNameAlreadyRegistered($name);
			if($count!=0)
			{
				$error = true;
				$nameError = "Name is already in use.";
			}
        }

		if (!filter_var($email,FILTER_VALIDATE_EMAIL))
		{
			$error = true;
			$emailError = "Please enter valid email address.";
		}
		else
		{
			$count = $accDB->isEMailAlreadyRegistered($email);
			if($count!=0)
			{
				$error = true;
				$emailError = "Provided Email is already in use.";
			}
		}

		if (empty($pass))
		{
			$error = true;
			$passError = "Please enter password.";
		}
		else if(strlen($pass) < 6)
		{
			$error = true;
			$passError = "Password must have atleast 6 characters.";
		}

		if(!$error)
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
	<div id="login-form">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
			<div class="col-md-4">
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
			</div>
		</form>
	</div>
</div>
</body>
</html>
<?php ob_end_flush(); ?>