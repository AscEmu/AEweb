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

ul.status {
  padding: 0;
  margin: 0;
}

li.status-online {
  display: block;
  height: auto;
  text-align: right;
  padding-right:20px;
  font-size: 9pt;
  color: #dbdbdb;
  border-radius: 20px;
}

li.status-online:nth-child(1) {
  -webkit-animation: pulse-online 2s alternate infinite;
  -moz-animation: pulse-online 2s alternate infinite;
}

@-webkit-keyframes pulse-online {
  0% {
    background: rgba(9, 158, 12, 1);
    box-shadow: inset 0px 0px 10px 2px rgba(9, 158, 12,0.5),
                      0px 0px 40px 2px rgba(9, 158, 12,1);
  }
  100% {
    background: rgba(9, 158, 12, 0);
    box-shadow: inset 0px 0px 10px 2px rgba(9, 158, 12,0.5),
                      0px 0px 30px 2px rgba(9, 158, 12,0.3);
  }
}
  
@-moz-keyframes pulse-online {
  0% {
    background: rgba(255,255,255,1);
    box-shadow: inset 0px 0px 10px 2px rgba(117,182,255,0.5),
                      0px 0px 40px 2px rgba(105,135,255,1);
  }
  100% {
    background: rgba(255,255,255,0);
    box-shadow: inset 0px 0px 10px 2px rgba(117,182,255,0.5),
                      0px 0px 30px 2px rgba(105,135,255,0.3);
  }
}
  
li.status-offline {
  display: block;
  height: auto;
  text-align: right;
  padding-right:20px;
  font-size: 9pt;
  color: #dbdbdb;
  border-radius: 20px;
}

li.status-offline:nth-child(1) {
  -webkit-animation: pulse-offline 2s alternate infinite;
  -moz-animation: pulse-offline 2s alternate infinite;
}

@-webkit-keyframes pulse-offline {
  0% {
    background: rgba(194,18,5,1);
    box-shadow: inset 0px 0px 10px 2px rgba(194,18,5,0.5),
                      0px 0px 40px 2px rgba(194,18,5,1);
  }
  100% {
    background: rgba(194,18,5, 0);
    box-shadow: inset 0px 0px 10px 2px rgba(194,18,5,0.5),
                      0px 0px 30px 2px rgba(194,18,5,0.3);
  }
}
  
@-moz-keyframes pulse-offline {
  0% {
    background: rgba(255,255,255,1);
    box-shadow: inset 0px 0px 10px 2px rgba(117,182,255,0.5),
                      0px 0px 40px 2px rgba(105,135,255,1);
  }
  100% {
    background: rgba(255,255,255,0);
    box-shadow: inset 0px 0px 10px 2px rgba(117,182,255,0.5),
                      0px 0px 30px 2px rgba(105,135,255,0.3);
  }
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
            $result = $accDB->getRealmDataForId($id);
            if ($result)
            {
                // get the status time
                $statusTime = new DateTime($result["status_change_time"]);
                $now = new DateTime();
                
                $diff = $now->diff($statusTime);
                
                //set up day, hour, minutes
                $format;
                
                $days = "";
                $hours = "";
                $minutes = "";
                
                if ($diff->format('%d') > 0)
                    if ($diff->format('%d') > 1)
                        $days = "%d days ";
                    else
                        $days = "%d day ";
                
                if ($diff->format('%h') > 0)
                    if ($diff->format('%h') > 1)
                        $hours = "%h hours ";
                    else
                        $hours = "%h hour ";
                
                if ($diff->format('%i') > 0)
                    if ($diff->format('%i') > 1)
                        $minutes = "%i minutes";
                    else
                        $minutes = "%i minute";
                
                $format = $days . $hours . $minutes;
                
                // echo day, hour, minutes
                if ($result['status'])
                    echo '<ul class="status">
                            <li class="status-online">Online '. $diff->format($format).'</li>
                          </ul>';
                else
                    echo '<ul class="status">
                            <li class="status-offline">Offline '. $diff->format($format).'</li>
                          </ul>';
            }
            else
            {
                echo 'no result from realms table';
            }
            echo '</div>';
        }
        echo '</div>';
    }
                
?>
</div>
