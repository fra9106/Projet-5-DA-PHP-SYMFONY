<?php

namespace App\routes;

use Control\{ConnectController, ControllerHome, ControllerArticles, ControllerUser};
use Exception;

class Router
{
    public function run()
    {
        try
        {
            if (isset($_GET['action'])){
                
                if ($_GET['action'] == 'homePage'){
                    $display = new ControllerHome();
                    $contact = $display->homePage();
                    
                }

                if ($_GET['action'] == 'sendMessage'){
                    if (isset($_POST['sendMessage']) and isset($_POST['username']) and isset($_POST['mail']) and isset($_POST['content'])){
                    $username = htmlspecialchars($_POST['username']);
                    $mail = htmlspecialchars($_POST['mail']);
                    $content = htmlspecialchars($_POST['content']);

                    $contact = new ControllerHome();
                    $infoscontact = $contact->sendMessage($username, $mail, $content);
                
                    }else{
                            throw new Exception('Message non envoyé !');
                         }
                }
                
                if ($_GET['action'] == 'displFormulContact'){
                    $display = new ConnectController();
                    $contact = $display->displFormulContact();
                }

                if ($_GET['action'] == 'displConnexion'){
                $display = new ConnectController();
                $contact = $display->displConnexion();
                }

                if ($_GET['action'] == 'login'){
                    if (isset($_POST['login']) and isset($_POST['mail']) and isset($_POST['mdp'])){
                        $mail = htmlspecialchars($_POST['mail']);

                        if (!empty(trim($_POST['mail'])) and !empty(trim($_POST['mdp']))){
                        $connex = new ConnectController();
                        $newConnexion = $connex->login($_POST['mail'], $_POST['mdp']);
                        }
                        else{
                        throw new Exception('Oups...Tous les champs doivent être complétés !');
                        }
                    }
                }

                if ($_GET['action'] == 'logout'){
                $lout = new ConnectController();
                $logOut = $lout->logout();

                }
                
                if ($_GET['action'] == 'addMember'){
                    if (isset($_POST['addMember']) and isset($_POST['pseudo']) and isset($_POST['mail']) and isset($_POST['mdp']))
                    {
                        $pseudo = htmlspecialchars($_POST['pseudo']);
                        $mail = htmlspecialchars($_POST['mail']);
                        if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mdp'])){
                            $pseudolength = strlen($pseudo);
                            if ($pseudolength > 2)
                            {
                                if (filter_var($mail, FILTER_VALIDATE_EMAIL)){
                                    $inscription = new ControllerUser();
                                    $contact = $inscription->addMember($_POST['pseudo'], $_POST['mail'], $_POST['mdp'], 'default.jpg');
                                    return $contact;
                                }
                                else{
                                    throw new Exception('Adresse mail non valide !');
                                }
                            }
                            else{
                                throw new Exception('Votre pseudo doit contenir plus de deux caractères !');
                            }
                        }
                        else{
                            throw new Exception('Tous les champs doivent être complétés');
                        }
                    }
                }
                /**
                 * list articles
                 */
                elseif ($_GET['action'] == 'listArticles'){
                        $listarticles = new ControllerArticles();
                        $list = $listarticles->listArticle();
                        //var_dump($articles); die;
                    }
                    /**
                     * get article by id
                     */
                  if ($_GET['action'] == 'getArticle'){ 
                        if (isset($_GET['id']) && $_GET['id'] > 0)
                        {
                            $article = new ControllerArticles();
                            $display = $article->getArticle();
                            
                        }
                        else
                        {
                            throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
                        }
                    }
                    /**
                     * add comment
                     */
                    if ($_GET['action'] == 'addComment'){
                        if (isset($_GET['id']) && $_GET['id'] > 0){
                            if (!empty($_GET['id']) && ($_POST['content'])){

                                $controlleruser = new ControllerArticles();
                                $addcomment = $controlleruser->addComment($_GET['id'], $_SESSION['id'], $_POST['content']);
                            }else{
                                throw new Exception('Oups... Tous les champs ne sont pas remplis !');
                                }
                        }else{
                            throw new Exception('Oups... Aucun identifiant article !');
                            }
                    }

                

                if ($_GET['action'] == 'listArticlesAdmin'){
                        $listarticles = new ControllerArticles();
                        $list = $listarticles->listArticlesAdmin();
                }

                if ($_GET['action'] == 'listUsersAdmin'){
                    $listUsers = new ControllerUser();
                    $list = $listUsers->listUsersAdmin();
                }

                if ($_GET['action'] == 'deleteUser'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){ //CONDITION DE SECURITE POUR EVITER DE POUVOIR ACCEDER A L'ADMIN PAR L'URL
                        header('Location:index.php?action=homePage');
                        }else{
                                if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                                    $controlleruser = new ControllerUser();
                                    $delete = $controlleruser->deleteUser($_GET['id']);
                                    
                                }
                             }
                }

                if ($_GET['action'] == 'editArticleAdmin'){
                    if (isset($_GET['id']) && $_GET['id'] > 0){
                        $controllerArticles = new ControllerArticles();
                        $display = $controllerArticles->editArticleAdmin();
                    }
                }

                if ($_GET['action'] == "updateArticleAdmin"){
                    if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                        $controlleradmin = new ControllerArticles();
                        $edit = $controlleradmin->updateArticleAdmin($_POST['mini_content'], $_POST['title'], $_POST['content'], $_GET['id']);
                        
                    }else{
                        throw new Exception('Impossible de modifier l\'article !');
                    }

                }

                if ($_GET['action'] == 'deleteArticle'){
                    if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                    $controlleradmin = new ControllerArticles();
                    $delete = $controlleradmin->deleteArticle($_GET['id']);
                    }
                }
                
                if ($_GET['action'] == 'writeArticleDisplay'){
                    
                    $controlleradmin = new ControllerArticles();
                    $adminconnect = $controlleradmin->formArticle();
                    }
                
                if ($_GET['action'] == 'articleWriting'){
                    
                    if (isset($_POST['send_article']) and isset($_POST['id_category']) and isset($_SESSION['id']) and isset($_POST['mini_content']) and isset($_POST['title']) and isset($_POST['content'])){
                        
                        $idCategory = ($_POST['id_category']);
                        $idUser = ($_SESSION['id']);
                        $miniContent = ($_POST['mini_content']);
                        $title = ($_POST['title']);
                        $content = ($_POST['content']);
                        
                        if (!empty(trim($_POST['mini_content'])) and !empty(trim($_POST['title'])) and !empty(trim($_POST['content']))){
                            $articleWrite = new ControllerArticles();
                            $display = $articleWrite->articleWriting($idCategory, $idUser, $miniContent, $title, $content);
                            //var_dump($idUser); die;
                        }
                        else{
                            throw new Exception('Vous n\'avez pas saisi d\'article !');
                        }
                    }
                }

                /**
                 * user profil 
                 */

                 if ($_GET['action'] == 'diplayprofil'){
                     $profilPage = new ControllerUser();
                     $page = $profilPage->displayprofil();
                 }
                
            }
            else{
                $vue = new ControllerHome();
                $accueil = $vue->homePage();
            }
        }
        catch(Exception $e){
           
            $loader = new \Twig\Loader\FilesystemLoader('../views/templates/security');
            $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
            $errorMessage = $e->getMessage();
            echo $twig->render('error.html.twig', ['error' => $errorMessage]);
            
        }
    }
}

