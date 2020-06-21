<?php

namespace App\routes;


use Control\{ConnectController, ControllerHome, ControllerArticles, ControllerUser};

use Exception;

class Router
{
    /**
     * instantiation variables
     *
     * @var [type]
     */
    private $home;
    private $connect;
    private $user;
    private $articles;
    private $loaderSecurit;
    private $twigySecur;
    private $action;

    /**
     * builder
     */
    public function __construct()
    {
        $this->home = new ControllerHome();
        $this->connect = new ConnectController();
        $this->user = new ControllerUser();
        $this->articles = new ControllerArticles();
        $this->loaderSecurit = new \Twig\Loader\FilesystemLoader('../views/templates/security');
        $this->twigySecur = new \Twig\Environment($this->loaderSecurit);
        $this->action = new Request();
    }
    
    public function run()
    {
        try
        {
           if($this->action->get('action')){ 
                $action = $this->action->get('action'); 
                /**
                 * home page
                 */
                if ($action == 'homePage'){
                    $this->home->homePage();
                }

                /**
                 * send message home page
                 */
                if ($action == 'sendMessage'){
                    $this->action->post('sendMessage');
                        $username = $this->action->post('username');
                        $mail = $this->action->post('mail'); 
                        $content = $this->action->post('content'); 
                        $this->home->sendMessage($username, $mail, $content);
                }else{
                    throw new Exception('Message non envoyé !');
                 }
            
                /**
                 * Legal Notice
                 */
                if ($action == 'legalPage'){
                   $this->home->legalPage();
                }

                /**
                 * display contact form 
                 */
                if ($action == 'displFormulContact'){
                    $this->connect->displFormulContact();
                }

                /**
                 * display connect form
                 */
                if ($action == 'displConnexion'){
                    $this->connect->displConnexion();
                }

                /**
                 * login
                 */
                if ($action == 'login'){
                    if (isset($_POST['login']) and isset($_POST['mail']) and isset($_POST['mdp'])){
                        $mail = htmlspecialchars($_POST['mail']);
                        if (!empty(trim($_POST['mail'])) and !empty(trim($_POST['mdp']))){
                            $this->connect->login($_POST['mail'], $_POST['mdp']);
                        }else{
                        throw new Exception('Oups...Tous les champs doivent être complétés !');
                        }
                    }
                }

                /**
                 * logout
                 */
                if ($action == 'logout'){
                    $this->connect->logout();
                }
                
                /**
                 * add member
                 */
                if ($action == 'addMember'){
                    if (isset($_POST['addMember']) and isset($_POST['pseudo']) and isset($_POST['mail']) and isset($_POST['mdp']) and isset($_POST['mdp2']) ){
                        $pseudo = htmlspecialchars($_POST['pseudo']);
                        $mail = htmlspecialchars($_POST['mail']);
                        if (!empty($_POST['pseudo']) and !empty($_POST['mail']) and !empty($_POST['mdp']) and !empty($_POST['mdp2']) ){
                            $pseudolength = strlen($pseudo);
                            if ($pseudolength > 2){
                                if (filter_var($mail, FILTER_VALIDATE_EMAIL)){
                                    $contact = $this->user->addMember($_POST['pseudo'], $_POST['mail'], $_POST['mdp'], 'default.jpg');
                                    return $contact;
                                }else{
                                    throw new Exception('Adresse mail non valide !');
                                }
                            }else{
                                throw new Exception('Votre pseudo doit contenir plus de deux caractères !');
                            }
                        }else{
                            throw new Exception('Tous les champs doivent être complétés');
                        }
                    }
                }
                /**
                 * list articles
                 */
                elseif ($action == 'listArticles'){
                       $this->articles->listArticle();
                    }

                    /**
                     * get article by id
                     */
                  if ($action == 'getArticle'){ 
                        if (isset($_GET['id']) && $_GET['id'] > 0){
                            $this->articles->getArticle();
                        }else{
                            throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
                        }
                    }
                    /**
                     * add comment
                     */
                    if ($action == 'addComment'){
                        if (isset($_GET['id']) && $_GET['id'] > 0){
                            if (!empty($_GET['id']) && ($_POST['content'])){
                                $this->articles->addComment($_GET['id'], $_SESSION['id'], $_POST['content']);
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
                if ($action == 'validComment'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == '0')){
                        header("Location: index.php?action=homePage");
                    }else{
                        if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                            $this->articles->validComment($_GET['id']);
                        }else{
                            throw new Exception('Oups....erreur de validation !');
                        }
                    }
                }
                        
                /**
                 * display list articles admin
                 */
                if ($action == 'listArticlesAdmin'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == '0')){
                        header("Location: index.php?action=homePage");
                    }else{
                        $this->articles->listArticlesAdmin();
                    }
                }

                /**
                 * display list membres admin
                 */
                if ($action == 'listUsersAdmin'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == '0')){
                        header("Location: index.php?action=homePage");
                    }else{
                        $this->user->listUsersAdmin();
                    }
                }

                /**
                 * display list comments admin
                 */
                if ($action == 'listCommentsAdmin'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == '0')){
                        header("Location: index.php?action=homePage");
                    }else{
                        $this->articles->listCommentsAdmin();
                    }
                }

                /**
                 * delete user
                 */
                if ($action == 'deleteUser'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                                if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                                    $this->user->deleteUser($_GET['id']);
                                    
                                }
                            }
                }

                /**
                 * confirm delete user
                 */
                if ($action == "confirmdeleteuser"){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if (isset($_GET['id']) && $_GET['id'] > 0){
                                $this->user->confirmdeleteuser();
                            }else{
                                throw new Exception('Oups... Aucun identifiant membre !');
                            }
                    }

                }
                /**
                 * edit article admin
                 */
                if ($action == 'editArticleAdmin'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if (isset($_GET['id']) && $_GET['id'] > 0){
                                $this->articles->editArticleAdmin();
                            }else{
                                throw new Exception('Oups... Aucun identifiant article !');
                            }
                        }
                }
                /**
                 * update article admin
                 */
                if ($action == "updateArticleAdmin"){
                    if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                        $this->articles->updateArticleAdmin($_POST['mini_content'], $_POST['title'], $_POST['content'], $_GET['id']);
                        }else{
                        throw new Exception('Impossible de modifier l\'article !');
                    }

                }

                /**
                 * delete article
                 */
                if ($action == 'deleteArticle'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                            $this->articles->deleteArticle($_GET['id']);
                            }
                        }
                    }

                /**
                 * confirm delete article
                 */
                if ($action == "confirmdeletearticle"){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if (isset($_GET['id']) && $_GET['id'] > 0){
                            $this->articles->confirmdeletearticle();
                            }else{
                                throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
                            }
                        }
                    }

                 /**
                 * delete comment
                 */
                if ($action == 'deleteComment'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if ((isset($_GET['id'])) && (!empty($_GET['id']))){
                                $this->articles->deleteComment($_GET['id']);
                            }
                        }
                    }


                /**
                 * confirm delete comment
                 */
                if ($action == "confirmdeletecomment"){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location:index.php?action=homePage');
                        }else{
                            if (isset($_GET['id']) && $_GET['id'] > 0){
                                $display = $this->articles->confirmdeletecomment();
                            }else{
                                throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
                            }
                        }
                    }
                
                /**
                 * display form to write article
                 */
                if ($action == 'writeArticleDisplay'){
                    if (!isset($_SESSION['droits']) || ($_SESSION['droits'] == 0)){
                        header('Location: index.php?action=homePage');
                    }else{
                        $this->articles->formArticle();
                        }
                    }
                
                /**
                 * send written article 
                 */
                if ($action == 'articleWriting'){
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
                                $this->articles->articleWriting($idCategory, $idUser, $miniContent, $title, $content);
                            }else{
                                throw new Exception('Vous n\'avez pas saisi d\'article !');
                            }
                        }
                    }
                }

                /**
                 * user profil page
                 */
                if ($action == 'diplayprofil'){
                    if (isset($_SESSION['id'])){
                        $this->user->displayprofil();
                    }else{
                        throw new Exception('Impossible d\'afficher la page profil, veuillez vous connecter !');
                    }
                }

                 /**
                  * display edit page profil user
                  */
                 if ($action == 'editprofilpage'){
                    if (isset($_SESSION['id'])){
                        $this->user->editprofilpage();
                    }else{
                        throw new Exception('Impossible d\'afficher la page edition de profil, veuillez vous connecter !');
                    }
                }

                 /**
                  * upload avatar file
                  */
                  if ($action == 'getAvatar'){
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
                                      $this->user->getAvatar($newavatar);
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
                    if ($action == 'updateUserPseudo')
                    {
                        if (isset($_POST['newpseudo']) and !empty($_POST['newpseudo']))
                        {
                            $newpseudo = htmlspecialchars($_POST['newpseudo']);
                            $this->user->updateUserPseudo($newpseudo);
                        }else{
                            throw new Exception('Merci de remplir le champ pseudo');
                        }
                    }

                    /**
                     * update mail
                     */
                    if ($action == 'updateUserMail'){
                        if (isset($_POST['newmail']) and !empty($_POST['newmail'])){
                            $newmail = htmlspecialchars($_POST['newmail']);
                            $this->user->updateUserMail($newmail);
                        }else{
                            throw new Exception('Merci de remplir le champ mail');
                        }
                    }

                    /**
                     * update password
                     */
                    if ($action == 'updateUserpwd'){
                        if (isset($_POST['newpwd']) and !empty($_POST['newpwd'])){
                            $newpwd = password_hash($_POST['newpwd'], PASSWORD_DEFAULT);
                            $this->user->updateUserpwd($newpwd);
                        }else{
                            throw new Exception('Merci de remplir le champ password');
                        }
                    }
                }else{
                    $this->home->homePage();
            }
        }catch(Exception $e){
           
            $errorMessage = $e->getMessage();
            $this->twigySecur->addGlobal('session', $_SESSION);
            echo $this->twigySecur ->render('error.html.twig', ['error' => $errorMessage], ['droits' => $_SESSION == 1]);
        }
    }
}

