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
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Include the default theme -->
<link rel="stylesheet" href="<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/themes/default.min.css" />

<!-- Include the editors JS -->
<script src="<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/sceditor.min.js"></script>

<!-- Include the BBCode or XHTML formats -->
<script src="<?php echo Config\Hosting::baseURL ?>include/sceditor-2.1.3/minified/formats/bbcode.js"></script>
    
<link rel="stylesheet" href="<?php echo Config\Hosting::baseURL ?>css/editor.css" type="text/css" />
</head>
<body>
