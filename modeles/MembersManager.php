<?php

namespace Mod;

require '../vendor/autoload.php';

use Mod\Manager;

class MembersManager extends Manager{

    /**
     * new member add
     *
     * @param [type] $pseudo
     * @param [type] $mail
     * @param [type] $mdp
     * @param [type] $avatar
     * @return void
     */
    public function insertMembre($pseudo, $mail, $mdp, $avatar)
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

    /**
     * test same mail
     *
     * @param [type] $mail
     * @return void
     */
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

    /**
     * get members admin
     *
     * @return void
     */
    public function getUsers()
    
    {
        $db = $this->dbConnect();
		$users = $db->prepare('SELECT id, pseudo, mail, DATE_FORMAT(create_date, \'%d/%m/%Y à %Hh%imin%ss\') AS create_date_fr FROM users');
        $users->execute(array());
        return $users;
    }

    /**
     * delete member and his comments
     *
     * @param [type] $idUser
     * @return void
     */
    public function deleteUse($idUser) 
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
     * confirm delete user
     *
     * @return void
     */
    public function infosUser()
    {
        $db = $this->dbConnect();
        $requser = $db->prepare("SELECT * FROM users WHERE id = ?");
        $requser->execute(array(
            $_GET['id']
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

    /**
     * update pseudo
     *
     * @param [type] $newpseudo
     * @return void
     */
    public function infoPseudo($newpseudo)
    {
        $db = $this->dbConnect();
        $insertpseudo = $db->prepare("UPDATE users SET pseudo = ? WHERE id = ?");
        $insertpseudo->execute(array(
            $newpseudo,
            $_SESSION['id']
        ));
        return $insertpseudo;
    }

    /**
     * update mail
     *
     * @param [type] $newmail
     * @return void
     */
    public function infoMail($newmail)
    {
        $db = $this->dbConnect();
        $insertmail = $db->prepare("UPDATE users SET mail = ? WHERE id = ?");
        $insertmail->execute(array(
            $newmail,
            $_SESSION['id']
        ));
        return $insertmail;
    }

    /**
     * update password
     *
     * @param [type] $newmdp
     * @return void
     */
    public function infopwd($newpwd) 
    {
        $db = $this->dbConnect();
        $insertpwd = $db->prepare("UPDATE users SET pass = ? WHERE id = ?");
        $insertpwd->execute(array(
            $newpwd,
            $_SESSION['id']
        ));
        return $insertpwd;
    }

}