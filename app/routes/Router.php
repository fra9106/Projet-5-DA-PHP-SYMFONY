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
                
                /**
                 * home page
                 */
                if ($_GET['action'] == 'homePage'){
                    $display = new ControllerHome();
                    $contact = $display->homePage();
                    
                }

                /**
                 * send message home page
                 */
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
                
                /**
                 * display contact form 
                 */
                if ($_GET['action'] == 'displFormulContact'){
                    $display = new ConnectController();
                    $contact = $display->displFormulContact();
                }

                /**
                 * display connect form
                 */
                if ($_GET['action'] == 'displConnexion'){
                $display = new ConnectController();
                $contact = $display->displConnexion();
                }

                /**
                 * login
                 */
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

                /**
                 * logout
                 */
                if ($_GET['action'] == 'logout'){
                    $lout = new ConnectController();
                    $logOut = $lout->logout();

                }
                
                /**
                 * add member
                 */
                if ($_GET['action'] == 'addMember'){
                    if (isset($_POST['addMember']) and isset($_POST['pseudo']) and isset($_POST['mail']) and isset($_POST['mdp']) and isset($_POST['mdp2']) )
                    {
                        $pseudo = htmlspecialchars($_POST['pseudo']);
                        $mail = htmlspecialchars($_POST['mail']);
                        if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mdp']) and !empty($_POST['mdp2']) ){
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

                /**
                 * valid comment
                 */
                if ($_GET['action'] == 'validComment'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == '0')){
                        header("Location: index.php?action=homePage");
                    }else{
                        if ((isset($_GET['id'])) && (!empty($_GET['id'])))
                        {
                            $controlleruser = new ControllerArticles();
                            $signale = $controlleruser->validComment($_GET['id']);
                        }else{
                            throw new Exception('Oups....erreur de validation !');
                        }
                    }
                }
                        
                /**
                 * display list articles admin
                 */
                if ($_GET['action'] == 'listArticlesAdmin'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == '0')){
                        header("Location: index.php?action=homePage");
                    }else{
                        $listarticles = new ControllerArticles();
                        $list = $listarticles->listArticlesAdmin();
                    }
                }

                /**
                 * display list membres admin
                 */
                if ($_GET['action'] == 'listUsersAdmin'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == '0')){
                        header("Location: index.php?action=homePage");
                    }else{
                        $listUsers = new ControllerUser();
                        $list = $listUsers->listUsersAdmin();
                    }
                }

                /**
                 * display list comments admin
                 */
                if ($_GET['action'] == 'listCommentsAdmin'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == '0')){
                        header("Location: index.php?action=homePage");
                    }else{
                    $listUsers = new ControllerArticles();
                    $list = $listUsers->listCommentsAdmin();
                    }
                }

                /**
                 * delete user
                 */
                if ($_GET['action'] == 'deleteUser'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                                if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                                    $controlleruser = new ControllerUser();
                                    $delete = $controlleruser->deleteUser($_GET['id']);
                                    
                                }
                             }
                }

                /**
                 * confirm delete user
                 */
                if ($_GET['action'] == "confirmdeleteuser"){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if (isset($_GET['id']) && $_GET['id'] > 0){
                                $confdelete = new ControllerUser();
                                $display = $confdelete->confirmdeleteuser();
                            }else{
                                throw new Exception('Oups... Aucun identifiant membre !');
                            }
                    }

                }
                /**
                 * edit article admin
                 */
                if ($_GET['action'] == 'editArticleAdmin'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if (isset($_GET['id']) && $_GET['id'] > 0){
                                $controllerArticles = new ControllerArticles();
                                $display = $controllerArticles->editArticleAdmin();
                            }else{
                                throw new Exception('Oups... Aucun identifiant article !');
                            }
                        }
                }
                /**
                 * update article admin
                 */
                if ($_GET['action'] == "updateArticleAdmin"){
                    if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                        $controlleradmin = new ControllerArticles();
                        $edit = $controlleradmin->updateArticleAdmin($_POST['mini_content'], $_POST['title'], $_POST['content'], $_GET['id']);
                        
                    }else{
                        throw new Exception('Impossible de modifier l\'article !');
                    }

                }

                /**
                 * delete article
                 */
                if ($_GET['action'] == 'deleteArticle'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                            $controllerarticle = new ControllerArticles();
                            $delete = $controllerarticle->deleteArticle($_GET['id']);
                            }
                        }
                    }

                /**
                 * confirm delete article
                 */
                if ($_GET['action'] == "confirmdeletearticle"){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if (isset($_GET['id']) && $_GET['id'] > 0){
                                $confdelete = new ControllerArticles();
                                $display = $confdelete->confirmdeletearticle();
                            }else{
                                throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
                            }
                        }
                    }

                 /**
                 * delete comment
                 */
                if ($_GET['action'] == 'deleteComment'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                            $controllerarticle = new ControllerArticles();
                            $delete = $controllerarticle->deleteComment($_GET['id']);
                            }
                        }
                    }


                /**
                 * confirm delete comment
                 */
                if ($_GET['action'] == "confirmdeletecomment"){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if (isset($_GET['id']) && $_GET['id'] > 0){
                                $confdelete = new ControllerArticles();
                                $display = $confdelete->confirmdeletecomment();
                            }else{
                                throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
                            }
                        }
                    }
                
                /**
                 * display form to write article
                 */
                if ($_GET['action'] == 'writeArticleDisplay'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location: index.php?action=homePage');
                    }else{
                        $controlleradmin = new ControllerArticles();
                        $adminconnect = $controlleradmin->formArticle();
                        }
                    
                    }
                
                /**
                 * send written article 
                 */
                if ($_GET['action'] == 'articleWriting'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location: index.php?action=homePage');
                    }else{
                    
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
                }

                /**
                 * user profil page
                 */
                if ($_GET['action'] == 'diplayprofil'){
                    if (isset($_SESSION['id'])){
                        $profilPage = new ControllerUser();
                        $page = $profilPage->displayprofil();

                    }else{
                        throw new Exception('Impossible d\'afficher la page profil, veuillez vous connecter !');
                    }
                }

                 /**
                  * display edit page profil user
                  */
                 if ($_GET['action'] == 'editprofilpage'){
                    if (isset($_SESSION['id']))
                    {
                        $all = new ControllerUser();
                        $user = $all->editprofilpage();
                    }else{
                        throw new Exception('Impossible d\'afficher la page edition de profil, veuillez vous connecter !');
                    }
                }

                 /**
                  * upload avatar file
                  */
                  if ($_GET['action'] == 'getAvatar'){
                      if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])){
                          $tailleMax = 2097152;
                          $extensionsValides = array(
                              'jpg',
                              'jpeg',
                              'gif',
                              'png'
                          );
                          if ($_FILES['avatar']['size'] <= $tailleMax){
                              $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.') , 1));
                              if (in_array($extensionUpload, $extensionsValides)){
                                  $chemin = "../publics/img/users/avatar/" . $_SESSION['id'] . "." . $extensionUpload;
                                  $resultat = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                                  if ($resultat){
                                      $newavatar = $_SESSION['id'] . "." . $extensionUpload;
                                      $controlleruser = new ControllerUser();
                                      $userAvatar = $controlleruser->getAvatar($newavatar);
                                    }else{
                                      throw new Exception('Erreur durant l\'importation de votre photo de profil !');
                                    }
                                }else{
                                  throw new Exception('Votre photo de profil doit être au format jpg, jpeg, gif ou png !');
                                }
                            }else{
                              throw new Exception('Votre photo de profil ne doit pas dépasser 2Mo !');
                            }
                        }else{
                            throw new Exception('Merci de selectionner une photo !');
                        }
                    }

                    /**
                     * update pseudo
                     */
                    if ($_GET['action'] == 'updateUserPseudo')
                    {
                        if (isset($_POST['newpseudo']) and !empty($_POST['newpseudo']))
                        {
                            $newpseudo = htmlspecialchars($_POST['newpseudo']);
                            $controlleruser = new ControllerUser();
                            $userpseudo = $controlleruser->updateUserPseudo($newpseudo);
                        }else{
                            throw new Exception('Merci de remplir le champ pseudo');
                        }
                    }

                    /**
                     * update mail
                     */
                    if ($_GET['action'] == 'updateUserMail')
                    {
                        if (isset($_POST['newmail']) and !empty($_POST['newmail']))
                        {
                            $newmail = htmlspecialchars($_POST['newmail']);
                            $controlleruser = new ControllerUser();
                            $usermail = $controlleruser->updateUserMail($newmail);
                        }else{
                            throw new Exception('Merci de remplir le champ mail');
                        }
                    }

                    /**
                     * update password
                     */
                    if ($_GET['action'] == 'updateUserpwd')
                    {
                        if (isset($_POST['newpwd']) and !empty($_POST['newpwd']))
                        {
                            $newpwd = password_hash($_POST['newpwd'], PASSWORD_DEFAULT);
                            $controlleruser = new ControllerUser();
                            $userpwd = $controlleruser->updateUserpwd($newpwd);
                        }else{
                            throw new Exception('Merci de remplir le champ password');
                        }
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
            $twig->addGlobal('session', $_SESSION);
            echo $twig->render('error.html.twig', ['error' => $errorMessage], ['droits' => $_SESSION == 1]);
            
        }
    }
}

