<?php

namespace Control;

require 'vendor/autoload.php';

use Mod\{MembersManager};

class ControllerUser {

    public function displFormulContact() // affichage formulaire de contact
    
    {
        $loader = new \Twig\Loader\FilesystemLoader('views/templates/security');
		$twig = new \Twig\Environment($loader);	

		echo $twig->render("sign_in.html.twig");	
    }

    public function addMember($pseudo, $mail, $mdp, $avatar) //ajout membre après divers tests
    
    {
        $membre = new MembersManager();
        $test = new MembersManager();

        $mdp = password_hash($_POST['mdp'], PASSWORD_DEFAULT); //hash mot de passe
        $testOk = $test->testMail($mail); // test pour ne pas avoir de mail en doublon
        if ($testOk == 0)
        {
            $newMembre = $membre->insertMembre($pseudo, $mail, $mdp, 'default.jpg');
            header("Location: index.php?action=homePage");
        }
        else
        {
            throw new \Exception('Oups... Adresse email déjà utilisée');
        }
    }

}