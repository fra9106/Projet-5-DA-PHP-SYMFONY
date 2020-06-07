<?php
namespace Mod;
require '../vendor/autoload.php';

class Manager
{
   protected function dbConnect()
    
    {
        $db = new \PDO('mysql:host=localhost;dbname=projet5_da_php;charset=utf8', 'root', '');
        $db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        
        return $db;

    }

    
}
