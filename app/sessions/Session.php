<?php

namespace App\sessions;

require '../vendor/autoload.php';

class Session
{

    public function rights($key, $value)
    {
        return $_SESSION[$key] == $value;
    }

    public function sess($key)
    {
        return !isset($_SESSION[$key]);
    }

    public function sessId($key)
    {
        return isset($_SESSION[$key]);
    }

}