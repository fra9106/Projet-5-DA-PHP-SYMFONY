<?php
namespace Mod;
require '../vendor/autoload.php';

use Mod\Manager;

class ConnectManager extends Manager{

    /**
     * login by mail
     *
     * @param [type] $mail
     * @return void
     */
    public function getConnect($mail) 
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE mail =  :mail');
        $req->execute(array(
            'mail' => $mail
        
        ));
        $connect = $req->fetch();
        return $connect;
    }

    /**
     * function remember me (checkbox)
     *
     * @param [type] $mail
     * @param [type] $mdp
     * @return void
     */
    public function remember($mail, $mdp)
    {
        $db = $this->dbConnect();
        $requser = $db->prepare("SELECT * FROM users WHERE mail = ? AND pass = ?");
        $requser->execute(array(
            $_COOKIE['mail'],
            $_COOKIE['pass']
        ));
        $usercook = $requser->rowCount();
        return $usercook;

    }
}