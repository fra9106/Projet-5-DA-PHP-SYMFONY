<?php
namespace Mod;
require '../vendor/autoload.php';

use Mod\Manager;

class MembersManager extends Manager{

    public function insertMembre($pseudo, $mail, $mdp, $avatar) //insertion infos nouveau membre en db
    
    {
        $db = $this->dbConnect();
        $insertmbr = $db->prepare("INSERT INTO users(pseudo, mail, pass, droits, avatar) VALUES(?, ?, ?, 0, ?)");
        $insertmbr->execute(array(
            $pseudo,
            $mail,
            $mdp,
            'franck.jpg'
        ));
        return $insertmbr;

    }

    
    public function testMail($mail) //test pour contrer doublon mail
    
    {
        $db = $this->dbConnect();
        $reqmail = $db->prepare("SELECT * FROM users WHERE mail = ?");
        $reqmail->execute(array(
            $mail
        ));
        $mailexist = $reqmail->rowCount();
        return $mailexist;
    }

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