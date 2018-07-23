<?php
	ob_start();
    session_start();
    
    require_once 'configs/web.conf.php';
    
    include_once 'include/database.inc.php';
    include_once 'include/accountDB.inc.php';
    include_once 'include/session.inc.php';
    include_once 'include/webDB.inc.php';
    include_once 'configs/realms.conf.php';

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
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity="sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
    
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.1/css/all.css" integrity="sha384-O8whS3fhG2OnA5Kas0Y9l3cfpmYjapjI0E4theH4iuMD+pLhbf6JI0jIMfYcK3yZ" crossorigin="anonymous">
    
<link rel="stylesheet" href="<?php echo Config\Hosting::baseURL ?>css/style.css" type="text/css" />
    
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
    
    <!-- Include the default theme -->
<link rel="stylesheet" href="<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/themes/default.min.css" />

<!-- Include the editors JS -->
<script src="<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/sceditor.min.js"></script>

<!-- Include the BBCode or XHTML formats -->
<script src="<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/formats/bbcode.js"></script>
    
<link rel="stylesheet" href="<?php echo Config\Hosting::baseURL ?>css/editor.css" type="text/css" />
</head>
<body>

<div class="user-bar">
    <div class="row">
        <div class="col-md-12">
            <div class="container">
            <?php
                if (!Session::get('userid'))
                {
            ?>
                <p>Welcome, Guest. Please <button type="button" class="btn btn-success btn-sm" onclick="overlayOn('login')">Login</button> or <button type="button" class="btn btn-success btn-sm" onclick="overlayOn('register')">Register</button></p>
            <?php
                }
                else
                {
                    $userFields = $webDB->getAllUserDataForAccount(Session::get('userid'));
                    $accountFields = $accDB->getAllAccountDataForAccount(Session::get('userid'));
                    if (!empty($userFields))
                    {
            ?>
                <p style="text-align:left;">
                    <img src="<?php echo Config\Hosting::baseURL ?>uploads/avatars/<?php echo $userFields['avatar'] ?>" width="35px" height="35px" style="border:3px solid grey; vertical-align: middle;" > Welcome back, <?php echo $userFields['displayName'] ?>
                    <span style="float:right;">
                        <a href="/admin/home" class="btn btn-dark btn-sm" role="button" aria-pressed="true"><i class="fas fa-hand-spock"></i> Admin Panel</a>
                        <a href="/acp" class="btn btn-info btn-sm" role="button" aria-pressed="true"><i class="fas fa-cogs"></i> Account Panel</a>
                        <a href="<?php echo Config\Hosting::baseURL ?>logout.php" class="btn btn-danger btn-sm" role="button" aria-pressed="true"><i class="fa fa-power-off"></i> Logout</a>
                    </span>
                </p>
            <?php
                    }
                }
            ?>
            </div>
        </div>
    </div>
</div>

<!-- test stuff - remove me after use -->
<div class="nav-holder">
    <div class="container">
         <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <a class="navbar-brand" href="<?php echo Config\Hosting::baseURL ?>">AEweb</a>

          <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
            <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
              <li class="nav-item active">
                <a class="nav-link" href="/home">Home <span class="sr-only">(current)</span></a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/test">Test</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="/test2">Test2</a>
              </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search" style="line-height: 1.5;"></i></button>
            </form>
          </div>
        </nav>
    </div>
</div> 
    
<div class="container">
    <div class="col-md-12">
        <?php include 'content/formErrors.cont.php'; ?>
        <?php include 'content/formLogin.cont.php'; ?>
        <?php include 'content/formRegister.cont.php'; ?>
    </div>
</div>