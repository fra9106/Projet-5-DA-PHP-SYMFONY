<?php
require 'vendor/autoload.php';

use Control\{ControllerHome, ControllerArticles};

try{
    if (isset($_GET['action'])) {
        if ($_GET['action'] == 'homePage') {
            $display = new ControllerHome();
            $contact = $display->homePage();

        }

        if ($_GET['action'] == 'listArticles')
        {
            $listarticles = new ControllerArticles();
            $list = $listarticles->listArticles();
            

        }

        if($_GET['action'] == 'lienRedacArticle'){

            $controlleradmin = new ControllerArticles();
            $adminconnect = $controlleradmin->formArticle();

        }

        if ($_GET['action'] == 'articleWriting')
        {
            if (isset($_POST['send_article']) and isset($_POST['id_category']) and isset($_POST['id_user'])  and isset($_POST['mini_content']) and isset($_POST['title']) and isset($_POST['content']))
            {
                $idCategory = ($_POST['id_category']);
                $idUser = ($_POST['id_user']);
                $miniContent = ($_POST['mini_content']);
                $title = ($_POST['title']);
                $content = ($_POST['content']);
                
                
                if (!empty(trim($_POST['mini_content'])) and !empty(trim($_POST['title'])) and !empty(trim($_POST['content'])))
                {
                    $redacArticle = new ControllerArticles();
                    $display = $redacArticle->articleWriting($idCategory, $idUser, $miniContent, $title, $content);
                }
                else
                {
                    throw new Exception('Vous n\'avez pas saisi d\'article !');
                }
            }
        }

    }else{ 
        $vue = new ControllerHome();
        $accueil = $vue->homePage();
    }
}catch(Exception $e)
{
    $errorMessage = $e->getMessage();
    //require ('views/frontend/errorView.php');
    echo "error";
}
