<?php

	error_reporting(~E_NOTICE);
	
	define('DB_HOST', 'localhost');
	define('DB_USER', 'root');
	define('DB_PASS', 'root');
	define('DB_NAME', 'asc_logon');
	
	$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	if (mysqli_connect_errno())
	{
		die("Connection failed : " . mysqli_connect_errno());
	}
