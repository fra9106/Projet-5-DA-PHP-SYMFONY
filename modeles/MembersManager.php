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

}