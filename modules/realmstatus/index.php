<?php include 'config.php'; ?>
<?php include 'class.php'; ?>

<style>

.realms-container
{
}

.realms-container .realm
{
    background-color: #111111;
    padding: 10px 15px;
    margin-bottom: 10px;
}

</style>

<div class="realms-container">
<?php
    $realmStatus;
                    
    foreach (Config\Realm::$realms as $id=>$info)
    {
        echo '<div class="realm">';
        $realmStatus[$id] = new RealmStatus($id, $info["dbhost"], $info["dbuser"], $info["dbpass"], $info["dbname"], $info["realmadress"], $info["realmport"]);
        if (!$realmStatus[$id])
        {
            echo 'Can\'t connect to realm db. Check out your realms.conf.php settings';
        }
        else
        {
            echo '<div class="realms">';
            echo '<h6>'.$info["name"].'</h6>';
            echo ''.$info["description"].'<br>';
            echo 'Version: '.$info["version"].' - Flags: '.$info["flags"].'<br>';
            echo '<p>'.$realmStatus[$id]->getCharacterCount().' Players</p>';
            echo '</div>';
        }
        echo '</div>';
    }
                
?>
</div>
