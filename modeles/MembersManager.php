<?php
namespace Mod;
require '../vendor/autoload.php';

use Mod\Manager;

class MembersManager extends Manager{

    public function insertMembre($pseudo, $mail, $mdp, $avatar) //insertion infos nouveau membre en db
    
    {
        $db = $this->dbConnect();
        $insertmbr = $db->prepare("INSERT INTO users(pseudo, mail, pass, droits, avatar, create_date) VALUES(?, ?, ?, 0, ?, NOW())");
        $insertmbr->execute(array(
            $pseudo,
            $mail,
            $mdp,
            'default.jpg'
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

    /**
     * user profil page
     * 
     * @return void
     */
    public function reqprofil()
    {
        $db = $this->dbConnect();
        $infos = $db->prepare('SELECT id, pseudo, mail, avatar, DATE_FORMAT(create_date, \'%d/%m/%Y à %Hh%imin%ss\') AS create_date_fr FROM users WHERE id = ?');
        $infos->execute(array($_SESSION['id']));
        $user = $infos->fetch();
        //var_dump($user); die;
        return $user;
    }

    /**
     * display edit page profil user
     *
     * @return void
     */
    public function infosProfil()
    {
        $db = $this->dbConnect();
        $requser = $db->prepare("SELECT * FROM users WHERE id = ?");
        $requser->execute(array(
            $_SESSION['id']
        ));
        $allinfos = $requser->fetch();
        return $allinfos;
    }


    /**
     * upload new profil picture
     *
     * @param [type] $newavatar
     * @return void
     */
    public function infosAvatar($newavatar)
    
    {
        $db = $this->dbConnect();
        $upavatar = $db->prepare("UPDATE users SET avatar = ? WHERE id = ?");
        $upavatar->execute(array(
            $newavatar,
            $_SESSION['id']
        ));
        return $upavatar;
    }





}