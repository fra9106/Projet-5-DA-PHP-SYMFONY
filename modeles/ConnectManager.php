<?php
namespace Mod;
require '../vendor/autoload.php';

use Mod\Manager;

class ConnectManager extends Manager{

   public function getConnect($mail) //récupère les information relative à la connexion de l'utilisateur inscrit en db
    
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM users WHERE mail =  :mail');
        $req->execute(array(
            'mail' => $mail
        
        ));
        $connect = $req->fetch();
        return $connect;
    }

    public function remember($mail, $mdp) // fonction se souvenir de moi
    
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