<?php
namespace App\routes;

class Request 
{
    /**
     *get function
     *
     * @param [type] $key
     * @return void
     */
    public function get($key = null)
    {
        $_GET = array_map('htmlspecialchars',$_GET);
        if($key) {
            return isset($_GET[$key]) ? $_GET[$key] : null;
         }
         return isset($_GET) ? $_GET : null;
    }

    /**
     *post function
     *
     * @param [type] $key
     * @return void
     */
    public function post($key=null)
    {   
        $_POST = array_map('htmlspecialchars',$_POST);
        if($key) {
           return isset($_POST[$key]) ? $_POST[$key] : null;
        }
        return isset($_POST) ? $_POST : null;
    }
   
}