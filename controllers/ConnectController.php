<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\ConnectManager;


class ConnectController 
{
    /**
     * instantiation variables
     *
     * @var [type]
     */
    private $loader;
    private $twig;
    private $member;

    /**
     * builder
     */
    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../views/templates/security');
        $this->twig = new \Twig\Environment($this->loader);
        $this->member = new ConnectManager();
    }

    /**
     * display contact form
     *
     * @return void
     */
    public function displFormulContact()
    {
        echo $this->twig->render("sign_in.html.twig");	
    }

    /**
     * display login form
     *
     * @return void
     */
    public function displConnexion()
    {
        echo $this->twig->render("log_in.html.twig");	
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
        $connect = $this->member->getConnect($mail);
        $isPasswordCorrect = password_verify($_POST['mdp'], $connect['pass']);
        $mdp = $connect['pass'];

        if (!$connect){
            throw new \Exception('Oups... Mauvais identifiant ou mot de passe !');
        }else{
            if ($isPasswordCorrect){
                if (isset($_POST['rememberme']))
                { 
                    setcookie('mail', $mail, time() + 365 * 24 * 3600, null, null, false, true); 
                    setcookie('mdp', $mdp, time() + 365 * 24 * 3600, null, null, false, true);
                }
                if (!isset($_SESSION['id']) and isset($_COOKIE['mail'], $_COOKIE['pass']) and !empty($_COOKIE['mail']) and !empty($_COOKIE['pass'])){ //si pas de session mais cookies pseudo et mdp...
                    $usercook = $this->member->remember($_COOKIE['mail'], $_COOKIE['pass']); //et on appelle la fonction remember avec les infos rapportés du modèle
                    if ($usercook == 1) {
                        
                        session_start();
                        $_SESSION['id'] = $connect['id'];
                        $_SESSION['pseudo'] = $connect['pseudo'];
                        $_SESSION['mail'] = $mail; 
                        $_SESSION['droits'] = $connect['droits'];
                        $_SESSION['avatar'] = $connect['avatar'];

                        header("Location: index.php?action=homePage");
                    }else{ 
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

            }else{
                throw new \Exception('Mauvais identifiant ou mot de passe !');
            }
            if (!empty($_SESSION['droits']) && $_SESSION['droits'] == '1') {
            
                header("Location: index.php?action=writeArticleDisplay");
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