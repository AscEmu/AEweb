<?php
	ob_start();
	include_once 'dbconfig.php';

	$error = false;

	if (isset($_POST['btn-signup']))
	{
		$name = trim($_POST['name']);
		$name = strip_tags($name);
		$name = htmlspecialchars($name);
		
		$email = trim($_POST['email']);
		$email = strip_tags($email);
		$email = htmlspecialchars($email);
		
		$pass = trim($_POST['pass']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		
		if (empty($name))
		{
			$error = true;
			$nameError = "Please enter your full name.";
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
			$query = "SELECT login FROM accounts WHERE login='$name'";
			$result = mysqli_query($conn, $query);
			$count = mysqli_num_rows($result);
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
			$query = "SELECT email FROM accounts WHERE email='$email'";
			$result = mysqli_query($conn, $query);
			$count = mysqli_num_rows($result);
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

		$password = hash('sha1', strtoupper($name . ':' . $pass));

		if(!$error)
		{
			$query = "INSERT INTO accounts(login, encrypted_password, gm, banned, email, flags, banreason) VALUES('$name', '$password', '0', '0', '$email', '24', '')";
			$res = mysqli_query($conn, $query);
				
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
<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"  />
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
						<input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php echo $name ?>" />
					</div>
					<span class="text-danger"><?php echo $nameError; ?></span>
				</div>
            
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon"><span class="fa fa-envelope" aria-hidden="true"></span></span>
						<input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php echo $email ?>" />
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
