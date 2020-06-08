<?php

namespace App\routes;

use Control\{ControllerHome, ControllerArticles, ControllerUser};
use Exception;

class Router
{
    public function run()
    {
        try
        {
            if (isset($_GET['action']))
            {
                
                if ($_GET['action'] == 'homePage')
                {
                    $display = new ControllerHome();
                    $contact = $display->homePage();
                    
                }
                
                if ($_GET['action'] == 'displFormulContact')
                {
                    $display = new ControllerUser();
                    $contact = $display->displFormulContact();
                    
                }
                
                if ($_GET['action'] == 'addMember')
                {
                    if (isset($_POST['addMember']) and isset($_POST['pseudo']) and isset($_POST['mail']) and isset($_POST['mdp']))
                    {
                        $pseudo = htmlspecialchars($_POST['pseudo']);
                        $mail = htmlspecialchars($_POST['mail']);
                        if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mdp']))
                        {
                            $pseudolength = strlen($pseudo);
                            if ($pseudolength > 2)
                            {
                                if (filter_var($mail, FILTER_VALIDATE_EMAIL))
                                {
                                    $inscription = new ControllerUser();
                                    $contact = $inscription->addMember($_POST['pseudo'], $_POST['mail'], $_POST['mdp'], 'default.jpg');
                                    return $contact;
                                }
                                else
                                {
                                    throw new Exception('Adresse mail non valide !');
                                }
                            }
                            else
                            {
                                throw new Exception('Votre pseudo doit contenir plus de deux caractères !');
                            }
                        }
                        else
                        {
                            throw new Exception('Tous les champs doivent être complétés');
                        }
                    }
                }
                
                if ($_GET['action'] == 'listArticles')
                {
                    $listarticles = new ControllerArticles();
                    $artic = $listarticles->listArticle();
                    //var_dump($artic); die;
                    
                }
                
                if ($_GET['action'] == 'writeArticleDisplay')
                {
                    
                    $controlleradmin = new ControllerArticles();
                    $adminconnect = $controlleradmin->formArticle();
                    
                }
                
                if ($_GET['action'] == 'articleWriting')
                {
                    
                    if (isset($_POST['send_article']) and isset($_POST['id_category']) /*and isset($_SESSION['id_user'])*/ and isset($_POST['mini_content']) and isset($_POST['title']) and isset($_POST['content']))
                    {
                        
                        $idCategory = ($_POST['id_category']);
                        //$idUser = ($_SESSION['id_user']);
                        $miniContent = ($_POST['mini_content']);
                        $title = ($_POST['title']);
                        $content = ($_POST['content']);
                        
                        if (!empty(trim($_POST['mini_content'])) and !empty(trim($_POST['title'])) and !empty(trim($_POST['content'])))
                        {
                            $articleWrite = new ControllerArticles();
                            $display = $articleWrite->articleWriting($idCategory, $idUser, $miniContent, $title, $content);
                            
                        }
                        else
                        {
                            throw new Exception('Vous n\'avez pas saisi d\'article !');
                        }
                    }
                }
                
            }
            else
            {
                $vue = new ControllerHome();
                $accueil = $vue->homePage();
            }
        }
        catch(Exception $e)
        {
            $errorMessage = $e->getMessage();
            //require ('views/frontend/errorView.php');
            echo "error";
        }
    }
}

