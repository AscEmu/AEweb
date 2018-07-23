<?php

$pageName = isset($_GET['page']) && !empty($_GET['page']) ? $_GET['page'] : 'home';

if (isset($_GET['dir']) && !empty($_GET['dir']))
{
    $dirName = $_GET['dir'];
    //if ($dirName == 'admin')
        include_once 'pages/'.$dirName.'/'.$pageName.'.page.php';
}
else
{
    include_once 'pages/'.$pageName.'.page.php';
}

?>

