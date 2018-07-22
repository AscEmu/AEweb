<?php

?>

<?php include 'content/header.cont.php'; ?>

<div class="main">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <?php include 'modules/slideshow/index.php'; ?>
            </div>
            <div class="col-md-4">
                <h3>Welcome to AEweb</h3>
                <p>AEweb is a PHP frontend server management Website. It is and probably will be the only web-project for AscEmu servers. This project was build from scratch without deal breaking requirements.</p>
                <p>We try to build well known functionality into this project to give AscEmu users a similar good experience on the web related site as with other projects.</p>
                <p>If you have some time on your hands, join the fun and influence the development with your skills and knowledge.</p>
            </div>
        </div>
    </div>
</div>
<div class="basic-padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <h3>News stuff</h3>
            </div>
            <div class="col-md-4">
                <?php
                    foreach (Config\Realm::$realms as $id=>$info)
                    {
                        echo '<div class="realms">';
                        echo '<h6>'.$info["name"].'</h6>';
                        echo ''.$info["description"].'<br>';
                        echo ''.$info["version"].' - '.$info["flags"].'<br>';
                        echo '</div><hr>';
                    }
                
                ?>
            </div>
        </div>
    </div>
</div>

<?php include 'content/footer.cont.php'; ?>
