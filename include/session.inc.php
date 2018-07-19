<?php

class Session
{
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    public static function setSecondKey($key, $secondKey, $value)
    {
        $_SESSION[$key][$secondKey] = $value;
    }
    
    public static function get($key)
    {
        if (isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return false;
        }
    }
    
    public static function getSecondKey($key, $secondKey = false)
    {
        if ($secondKey != false)
        {
            if (isset($_SESSION[$key][$secondKey]))
            {
                return $_SESSION[$key][$secondKey];
            }
            else
            {
                return get($key);
            }
        }
    }
}

?>