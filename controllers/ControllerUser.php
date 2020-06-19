<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\MembersManager;

class ControllerUser {

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../views/templates/profils');
        $this->twig = new \Twig\Environment($this->loader);
        $this->loadAdmin = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $this->adminTwig = new \Twig\Environment($this->loadAdmin);
        $this->loaderSecurit = new \Twig\Loader\FilesystemLoader('../views/templates/security');
        $this->twigySecur = new \Twig\Environment($this->loaderSecurit);
        $this->member = new MembersManager();
        $this->test = new MembersManager();
    }

    /**
     * add member
     *
     * @param [type] $pseudo
     * @param [type] $mail
     * @param [type] $mdp
     * @param [type] $avatar
     * @return void
     */
    public function addMember($pseudo, $mail, $mdp, $avatar)
    {
        $mdp = $_POST['mdp']; 
        $mdp2 = $_POST['mdp2'];
        if ($mdp == $mdp2) {
            $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT);
        }else{
            throw new \Exception('Oups... mots de passe différent');
        }
        $testOk = $this->test->testMail($mail);  
        if ($testOk == 0 ){
            $this->member->insertMembre($pseudo, $mail, $mdp, 'default.jpg');
            header("Location:index.php?action=displConnexion ");
            }else{
                throw new \Exception('Oups... Adresse email déjà utilisée');
            }
        }

    /**
     * list members
     *
     * @return void
     */
    public function listUsersAdmin() 
    {
        $users = $this->member->getUsers();
        $this->twig->addGlobal('session', $_SESSION);
        echo $this->twig->render('listUsers.html.twig',['users' => $users], ['droits' => $_SESSION == 1] );
    }

    /**
     * delete member
     *
     * @param [type] $idUser
     * @return void
     */
    public function deleteUser($idUser) 
    {
        $delete = $this->member->deleteUse($idUser);
        if ($delete === false){
            throw new \Exception('Impossible de supprimer cet article!');
        }else{
            header('Location: index.php?action=listUsersAdmin');
        }
    }

    /**
     * confirm delete user
     *
     * @return void
     */
    public function confirmdeleteuser() 
    {
        $users = $this->member->infosUser();
        $this->twig->addGlobal('session', $_SESSION);
        echo $this->twig->render('confirmdeleteuser.html.twig',['users' => $users], ['droits' => $_SESSION == 1] );
    }

    /**
     * user profil page
     *
     * @return void
     */
    public function displayprofil()
    {
        $user = $this->member->reqprofil();
        $this->twig->addGlobal('session', $_SESSION);
        echo $this->twig->render('profil.html.twig',['user' => $user], ['droits' => $_SESSION == 1] );
    }

    /**
     * display edit page profil user
     *
     * @return void
     */
    public function editprofilpage() 
    {
        $user = $this->member->infosProfil();
        $this->twig->addGlobal('session', $_SESSION);
        echo $this->twig->render('editprofil.html.twig',['user' => $user], ['droits' => $_SESSION == 1] );
    }

    /**
     * upload avatar file
     *
     * @param [type] $newavatar
     * @return void
     */
    public function getAvatar($newavatar)
    {
        $this->member->infosAvatar($newavatar);
        header('Location: index.php?action=diplayprofil&id='.$_SESSION['id']);
    }

    /**
     *update pseudo
     *
     * @param [type] $newpseudo
     * @return void
     */
    public function updateUserPseudo($newpseudo) 
    {
        $this->member->infoPseudo($newpseudo);
        header('Location: index.php?action=diplayprofil&id='.$_SESSION['id']);
    }

    /**
     * update mail
     *
     * @param [type] $newmail
     * @return void
     */
    public function updateUserMail($newmail)
    {
        $testOk = $this->test->testMail($newmail);
        if ($testOk == 0){ 
            $this->membre->infoMail($newmail);
            header('Location: index.php?action=diplayprofil&id='.$_SESSION['id']);
        }
    }

    /**
     * update password
     *
     * @param [type] $newmdp
     * @return void
     */
    public function updateUserpwd($newpwd) // update le motdepasse
    {
    
        $this->member->infopwd($newpwd);
        header('Location: index.php?action=diplayprofil&id='.$_SESSION['id']);
    }

}