<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\{MembersManager};

class ControllerUser {

    public function addMember($pseudo, $mail, $mdp, $avatar) //ajout membre après divers tests
    
    {
        $membre = new MembersManager();
        $test = new MembersManager();

        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); //hash mot de passe
        $testOk = $test->testMail($mail); // test pour ne pas avoir de mail en doublon
        if ($testOk == 0)
        {
            $newMembre = $membre->insertMembre($pseudo, $mail, $mdp, 'default.jpg');
            header("Location:index.php?action=displConnexion ");
        }
        else
        {
            throw new \Exception('Oups... Adresse email déjà utilisée');
        }
    }


    public function listUsersAdmin() {

        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $usersManager = new MembersManager();
        $users = $usersManager->getUsers();
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render('listUsers.html.twig',['users' => $users], ['droits' => $_SESSION == 1] );
    }

    public function deleteUser($idUser) 
    
    {
        $deleteuser = new MembersManager();
        $delete = $deleteuser->deleteUse($idUser);
       
        if ($delete === false)
        {
            throw new \Exception('Impossible de supprimer cet article!');
        }
        else
        {
            header('Location: index.php?action=listUsersAdmin');
        }
    }

    /**
     * confirm delete user
     *
     * @return void
     */
    public function confirmdeleteuser() {

        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/security');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $usersManager = new MembersManager();
        $users = $usersManager->infosUser();
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render('confirmdeleteuser.html.twig',['users' => $users], ['droits' => $_SESSION == 1] );
    }


    /**
     * user profil page
     *
     * @return void
     */
    public function displayprofil()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/profils');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
        $page = new MembersManager();
        $user = $page->reqprofil();
        
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render('profil.html.twig',['user' => $user], ['droits' => $_SESSION == 1] );
    }

    /**
     * display edit page profil user
     *
     * @return void
     */
    public function editprofilpage() 
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/profils');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
        $infosmembre = new MembersManager();
        $user = $infosmembre->infosProfil();
        
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render('editprofil.html.twig',['user' => $user], ['droits' => $_SESSION == 1] );
    }


    /**
     * upload avatar file
     *
     * @param [type] $newavatar
     * @return void
     */
    public function getAvatar($newavatar)
    {
        $membreManager = new MembersManager();
        $avatarinfos = $membreManager->infosAvatar($newavatar);
        throw new \Exception('Avatar modifié !');
    }

    /**
     *update pseudo
     *
     * @param [type] $newpseudo
     * @return void
     */
    public function updateUserPseudo($newpseudo) 
    {
        $infosmembre = new MembersManager();
        $pseudoinfos = $infosmembre->infoPseudo($newpseudo);
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
        $test = new MembersManager();
        $testOk = $test->testMail($newmail);
        if ($testOk == 0)
        { 
            $infosmembre = new MembersManager();
            $mailinfos = $infosmembre->infoMail($newmail);
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
        $infosmembre = new MembersManager();
        $pwdinfos = $infosmembre->infopwd($newpwd);
        header('Location: index.php?action=diplayprofil&id='.$_SESSION['id']);
    }




    

}