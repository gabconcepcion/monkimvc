<?php

class Monki_Session
{
    function __construct()
    {
        session_start();    
    }
    
    function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    
    function get($key)
    {
            return $_SESSION[$key];
    }
    
    function destroy()
    {
            session_destroy();
    }

}