<?php
// Realm related settings

namespace Config
{
    class Realm
    {
        static public $realms = [
            1 => [
                "dbhost" => "localhost",
                "dbuser" => "root",
                "dbpass" => "root",
                "dbname" => "asc_char",
                
                "realmadress" => "127.0.0.1",
                "realmport" => "8129",
                
                "id" => 1,
                "name" => "UberRealm XXX",
                "description" => "Something unique - 100K online playerz!",
                "version" => "3.3.5a",
                "flags" => 24
            ],
            2 => [
                "dbhost" => "localhost",
                "dbuser" => "root",
                "dbpass" => "root",
                "dbname" => "asc_char",
                
                "realmadress" => "127.0.0.1",
                "realmport" => "8130",
                
                "id" => 2,
                "name" => "BCRealm YYY",
                "description" => "Back to the roots",
                "version" => "2.4.3",
                "flags" => 8
            ]
        ];
    }
}

?>
