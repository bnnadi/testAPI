<?php

namespace core\utilities;

class Session
{
    var $session_id;
    function __construct()
    {
        $this->start();
    }
    function start()
    {
        if (session_start() == '') {
            session_start();
        }
    }
    function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }
    function get($key)
    {
        if (isset($_SESSION[$key]))
            return $_SESSION[$key];
        return '';
    }
}