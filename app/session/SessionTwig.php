<?php

namespace App\session;

require '../vendor/autoload.php';

use Control\{ConnectController, ControllerHome, ControllerArticles, ControllerUser};

class SessionTwig
{
    
    

    public function twigSession()
    {
        $loader = new \Twig\Loader\FilesystemLoader();
		$twig = new \Twig\Environment($loader);	
        $twig->addGlobal('session', $_SESSION);
        return $twig;
       
    }
}