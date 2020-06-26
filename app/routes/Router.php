<?php

namespace App\routes;


use Control\{ConnectController, ControllerHome, ControllerArticles, ControllerUser};
use App\sessions\Session;
use Exception;

class Router
{
    /**
     * class properties
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
    private $session;

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
        $this->session = new Session();
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
                                    $contact = $this->user->addMember ($_POST['pseudo'], $_POST['mail'], $_POST['mdp'], 'default.jpg');
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
                  if ($action == 'listArticles'){
                       $this->articles->listArticle();
                    }
                
                /**
                 * get articles by categories
                 */
                if ($action == 'catArticles'){
                    $idCategory = $this->action->get('id_category');
                    $this->articles->catArticles($idCategory);
                    
                }

                /**
                     * get article by id
                     */
                  if ($action == 'getArticle'){ 
                        if ($this->action->get('id') > 0){
                            $this->articles->getArticle();
                        }else{
                            throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
                        }
                    }
                    /**
                     * add comment
                     */
                    if ($action == 'addComment'){
                        if ($this->action->get('id') > 0){
                            if (!empty ($this->action->get('id') && ($this->action->post('content')))){
                                $getId = $this->action->get('id');
                                $sess = $this->session->sessId('id');
                                $postId = $this->action->post('content');
                                $this->articles->addComment($getId, $sess, $postId);
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
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                    }else{
                        if ($this->action->get('id') && (!empty($this->action->get('id')))){
                            $idComment = $this->action->get('id');
                            $this->articles->validComment($idComment);
                        }else{
                            throw new Exception('Oups....erreur de validation !');
                        }
                    }
                }

                /**
                 * valid editor article
                 */
                if ($action == 'validArticle'){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                    }else{
                        if ($this->action->get('id') && (!empty($this->action->get('id')))){
                            $idArticle = $this->action->get('id');
                            $this->articles->validArticle($idArticle);
                        }else{
                            throw new Exception('Oups....erreur de validation !');
                        }
                    }
                }
                        
                /**
                 * display list articles admin
                 */
                if ($action == 'listArticlesAdmin'){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0))){
                        header("Location: index.php?action=homePage");
                    }else{
                        $this->articles->listArticlesAdmin();
                    }
                }

                /**
                 * display list membres admin
                 */
                if ($action == 'listUsersAdmin'){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                    }else{
                        $this->user->listUsersAdmin();
                    }
                }

                /**
                 * display list comments admin
                 */
                if ($action == 'listCommentsAdmin'){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                    }else{
                        $this->articles->listCommentsAdmin();
                    }
                }

                /**
                 * delete user
                 */
                if ($action == 'deleteUser'){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                        }else{
                                if ($this->action->get('id') && $this->action->get('id') > 0){
                                    $idUser = $this->action->get('id');
                                    $this->user->deleteUser($idUser);
                                    
                                }
                            }
                }

                /**
                 * confirm delete user
                 */
                if ($action == "confirmdeleteuser"){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                        }else{
                            if ($this->action->get('id') && $this->action->get('id') > 0){
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
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                        }else{
                            if ($this->action->get('id') && $this->action->get('id') > 0){
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
                    if ($this->action->get('id') && (!empty($this->action->get('id')))){
                        $postMini = $this->action->post('mini_content');
                        $postTitle = $this->action->post('title');
                        $postContent = $this->action->post('content');
                        $getId = $this->action->get('id');
                        $this->articles->updateArticleAdmin($postMini, $postTitle, $postContent, $getId);
                        }else{
                            throw new Exception('Impossible de modifier l\'article !');
                    }

                }

                /**
                 * delete article
                 */
                if ($action == 'deleteArticle'){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                        }else{
                            if ($this->action->get('id') && (!empty($this->action->get('id')))){
                                $dataId = $this->action->get('id');
                                $this->articles->deleteArticle($dataId);
                            }
                        }
                    }

                /**
                 * confirm delete article
                 */
                if ($action == "confirmdeletearticle"){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                        }else{
                            if ($this->action->get('id') && $this->action->get('id') > 0){
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
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                        }else{
                            if ($this->action->get('id') && (!empty($this->action->get('id')))){
                                $dataId = $this->action->get('id');
                                $this->articles->deleteComment($dataId);
                            }
                        }
                    }


                /**
                 * confirm delete comment
                 */
                if ($action == "confirmdeletecomment"){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0) || $this->session->rights('droits', 2))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                        }else{
                            if ($this->action->get('id') && $this->action->get('id') > 0){
                                $this->articles->confirmdeletecomment();
                            }else{
                                throw new Exception('Oups... Aucun identifiant d\'article envoyé !');
                            }
                        }
                    }
                
                /**
                 * display form to write article
                 */
                if ($action == 'writeArticleDisplay'){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
                    }else{
                        $this->articles->formArticle();
                        }
                    }
                
                /**
                 * send written article 
                 */
                if ($action == 'articleWriting'){
                    if ($this->session->sess('droits') || ($this->session->rights('droits', 0))){
                        throw new Exception('Votre statut ne vous permet pas d\'accéder à cette fonction !');
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
                    if ($this->session->sessId('id')){
                        $this->user->displayprofil();
                    }else{
                        throw new Exception('Impossible d\'afficher la page profil, veuillez vous connecter !');
                    }
                }

                 /**
                  * display edit page profil user
                  */
                 if ($action == 'editprofilpage'){
                    if ($this->session->sessId('id')){
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
                    if ($action == 'updateUserPseudo'){
                        if ($this->action->post('newpseudo') && (!empty($this->action->post('newpseudo')))){
                            $newpseudo = htmlspecialchars($this->action->post('newpseudo'));
                            $this->user->updateUserPseudo($newpseudo);
                        }else{
                            throw new Exception('Merci de remplir le champ pseudo');
                        }
                    }

                    /**
                     * update mail
                     */
                    if ($action == 'updateUserMail'){
                        if ($this->action->post('newmail') && (!empty($this->action->post('newmail')))){
                            $newmail = htmlspecialchars($this->action->post('newmail'));
                            $this->user->updateUserMail($newmail);
                        }else{
                            throw new Exception('Merci de remplir le champ mail');
                        }
                    }

                    /**
                     * update password
                     */
                    if ($action == 'updateUserpwd'){
                        if ($this->action->post('newpwd') && (!empty($this->action->post('newpwd')))){
                            $newpwd = password_hash($this->action->post('newpwd'), PASSWORD_DEFAULT);
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

