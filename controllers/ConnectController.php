<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\{ConnectManager};

class ConnectController {

    /**
     * display contact form
     *
     * @return void
     */
    public function displFormulContact()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/security');
		$twig = new \Twig\Environment($loader);	
        $twig->addGlobal('session', $_SESSION);   
		echo $twig->render("sign_in.html.twig", ['droits' => $_SESSION == 1]);	
    }

    /**
     * display login form
     *
     * @return void
     */
    public function displConnexion()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/security');
		$twig = new \Twig\Environment($loader);	
        $twig->addGlobal('session', $_SESSION);   
		echo $twig->render("log_in.html.twig", ['droits' => $_SESSION == 1]);	
    }

    /**
     * login
     *
     * @param [type] $mail
     * @param [type] $pass
     * @return void
     */
    public function login($mail, $pass) 
    {
        $membre = new ConnectManager();
        $connect = $membre->getConnect($mail);
        $isPasswordCorrect = password_verify($_POST['mdp'], $connect['pass']);
        $mdp = $connect['pass'];

        if (!$connect)
        {
            throw new \Exception('Oups... Mauvais identifiant ou mot de passe !');
        }
        else
        {

            if ($isPasswordCorrect)
            {
                if (isset($_POST['rememberme']))
                { 
                    setcookie('mail', $mail, time() + 365 * 24 * 3600, null, null, false, true); 
                    setcookie('mdp', $mdp, time() + 365 * 24 * 3600, null, null, false, true);
                }
                if (!isset($_SESSION['id']) and isset($_COOKIE['mail'], $_COOKIE['pass']) and !empty($_COOKIE['mail']) and !empty($_COOKIE['pass']))
                { //si pas de session mais cookies pseudo et mdp...
                    $member = new ConnectManager(); //on instancie la class MembersManager...
                    $usercook = $member->remember($_COOKIE['mail'], $_COOKIE['pass']); //et on appelle la fonction remember avec les infos rapportés du modèle
                
                    if ($usercook == 1) // si cookies pseuso et mdp == à 1
                    
                    { // on ouvre les différentes sessions et rdv à la page d'accueil
                        session_start();
                        $_SESSION['id'] = $connect['id'];
                        $_SESSION['pseudo'] = $connect['pseudo'];
                        $_SESSION['mail'] = $mail; 
                        $_SESSION['droits'] = $connect['droits'];
                        $_SESSION['avatar'] = $connect['avatar'];

                        header("Location: index.php?action=homePage");
                    }
                    else
                    { 
                        throw new \Exception('Oups... Veuillez vous reconnecter !');
                    }
                }
                session_start();
                $_SESSION['id'] = $connect['id'];
                $_SESSION['pseudo'] = $connect['pseudo'];
                $_SESSION['mail'] = $mail;
                $_SESSION['droits'] = $connect['droits'];
                $_SESSION['avatar'] = $connect['avatar'];
                
                header("Location: index.php?action=homePage");

            }
            else
            {
                throw new \Exception('Mauvais identifiant ou mot de passe !');
            }
            if (!empty($_SESSION['droits']) && $_SESSION['droits'] == '1') {
                //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                header("Location: index.php?action=homePage");
            }           
        }
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        session_start();
        setcookie('mail', '', time() - 3600);
        setcookie('mdp', '', time() - 3600);
        $_SESSION = array();
        session_destroy();
        header("Location: index.php?action=homePage");
    }
}