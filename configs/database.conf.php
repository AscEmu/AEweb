<?php
// Setup db connection information.

namespace Config
{
    // web db
    class WebDB
    {
        const dbhost = 'localhost';
        const dbuser = 'root';
        const dbpass = 'root';
        const dbname = 'asc_web';
    }
    
    // account db
    class AccountDB
    {
        const dbhost = 'localhost';
        const dbuser = 'root';
        const dbpass = 'root';
        const dbname = 'asc_logon';
    }
}

?>
