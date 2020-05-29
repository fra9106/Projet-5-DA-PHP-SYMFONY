<?php
require 'vendor/autoload.php';
use Control\ControllerHome;

try{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'homePage') {
            $display = new ControllerHome();
            $contact = $display->homePage();

        }

    }else{  //pageAccueil(); //si aucune action, alors affiche moi la page d'accueil ;)
        $vue = new ControllerHome();
        $accueil = $vue->homePage();
    }
}catch(Exception $e)
{
    $errorMessage = $e->getMessage();
    require ('views/frontend/errorView.php');
}
