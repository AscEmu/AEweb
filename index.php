<?php

$pageName = isset($_GET['page']) ? $_GET['page'] : 'home';

include_once 'pages/'.$pageName.'.page.php';

?>

