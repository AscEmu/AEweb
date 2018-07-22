<?php include 'config.php'; ?>
<?php include 'class.php'; ?>

<style>

.realms-container
{
    background-color: #000;
}

</style>

<div class="realms-container">
<?php
    $realmDB;
                    
    foreach (Config\Realm::$realms as $id=>$info)
    {
        $realmDB[$id] = new RealmStatus($info["dbhost"], $info["dbuser"], $info["dbpass"], $info["dbname"]);
        if (!$realmDB[$id])
        {
            echo 'Can\'t connect to realm db. Check out your realms.conf.php settings';
        }
        else
        {
            echo '<div class="realms">';
            echo '<h6>'.$info["name"].'</h6>';
            echo ''.$info["description"].'<br>';
            echo 'Version: '.$info["version"].' - Flags: '.$info["flags"].'<br>';
            echo '<p>'.$realmDB[$id]->getCharacterCount().' Players</p>';
            echo '</div>';
        }
    }
                
?>
</div>
