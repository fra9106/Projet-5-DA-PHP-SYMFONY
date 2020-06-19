<?php
namespace Mod;
require '../vendor/autoload.php';

use Mod\Manager;

class MembersManager extends Manager{

    public function insertMembre($pseudo, $mail, $mdp, $avatar) //insertion infos nouveau membre en db
    
    {
        $db = $this->dbConnect();
        $insertmbr = $db->prepare("INSERT INTO users(pseudo, mail, pass, droits, avatar, creation_date) VALUES(?, ?, ?, 0, ?, NOW())");
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

    public function getUsers()
    
    {
        $db = $this->dbConnect();
		$users = $db->prepare('SELECT id, pseudo, mail, DATE_FORMAT(create_date, \'%d/%m/%Y à %Hh%imin%ss\') AS create_date_fr FROM users');
        $users->execute(array());
        return $users;


    }
    public function deleteUse($idUser) //supprime un user et ses commentaires (admin)
	{ 
        $db = $this->dbConnect();
        $comment = $db->prepare('DELETE FROM comments WHERE id_user = ?');
        $comment->execute([$idUser]);
        $req = $db->prepare('DELETE FROM users WHERE id = ?');
        $req->execute(array($idUser));
        
       	return $req;
    }




}