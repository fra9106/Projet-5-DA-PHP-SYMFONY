<?php

namespace App\sessions;

require '../vendor/autoload.php';

class Session
{
    /**
     * rights session
     *
     * @param [type] $key
     * @param [type] $value
     * @return void
     */
    public function rights($key, $value)
    {
        return $_SESSION[$key] == $value;
    }

    /**
     * session
     *
     * @param [type] $key
     * @return void
     */
    public function sess($key)
    {
        return !isset($_SESSION[$key]);
    }

    /**
     * session by id
     *
     * @param [type] $key
     * @return void
     */
    public function sessId($key)
    {
        return isset($_SESSION[$key]);
    }

}