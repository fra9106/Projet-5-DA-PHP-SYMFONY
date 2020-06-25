<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\{ArticlesManager, CommentsManager};
use App\routes\request;
use Exception;

class ControllerArticles
{
    /**
     * class properties
     *
     * @var [type]
     */
    private $loader;
    private $twig;
    private $loadAdmin;
    private $adminTwig;
    private $loaderSecurit;
    private $twigySecur;
    private $articlesManager;
    private $commentsManager;
    private $action;

    /**
     * builder
     */
    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../views/templates/articles');
        $this->twig = new \Twig\Environment($this->loader);
        $this->loadAdmin = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $this->adminTwig = new \Twig\Environment($this->loadAdmin);
        $this->loaderSecurit = new \Twig\Loader\FilesystemLoader('../views/templates/security');
        $this->twigySecur = new \Twig\Environment($this->loaderSecurit);
        $this->articlesManager = new ArticlesManager();
        $this->commentsManager = new CommentsManager();
        $this->action = new Request();
    }

    /**
     * listing articles
     *
     * @return void
     */
    public function listArticle() 
    {
        if ($articles = $this->articlesManager->getArticles()){
            $this->twig->addGlobal('session', $_SESSION);   
            echo $this->twig->render('articles.html.twig',['articles' => $articles], ['droits' => $_SESSION == 1]);
        }else{
            throw new Exception('impossible d\'afficher les articles');
        }
    }

    /**
     * get articles by categories
     *
     * @param [type] $idCategory
     * @return void
     */
    public function catArticles($idCategory)
    {
        if($articles = $this->articlesManager->getArticlesByCat($idCategory)){
            $this->twig->addGlobal('session', $_SESSION);   
            echo $this->twig->render('articles.html.twig',['articles' => $articles], ['droits' => $_SESSION == 1]);
        }else{
            throw new Exception('impossible d\'afficher les catégories');
        }
    }

    /**
     * getting article and his comments
     *
     * @return void
     */
    public function getArticle()
    {
        if($getId = $this->action->get('id')){
        $article = $this->articlesManager->Article($getId);
        $comments = $this->commentsManager->getComments($getId);
        $this->twig->addGlobal('session', $_SESSION);
        echo $this->twig->render('article.html.twig',['comments' => $comments,'article' => $article],  ['droits' => $_SESSION == 1]);
        }else{
        throw new Exception('impossible de récupérer l\'article');
        }
    }

    /**
     * add comment
     *
     * @param [type] $idArticle
     * @param [type] $idUser
     * @param [type] $content
     * @return void
     */
    public function addComment($idArticle, $idUser, $content)
    {
        $content = htmlspecialchars($content);
        $affectedLines = $this->commentsManager->postComment($idArticle, $_SESSION['id'], $content);
        if ($affectedLines === true){ 
            header('Location: index.php?action=getArticle&id=' . $idArticle);
            }else{
            throw new \Exception('Oups... Impossible d\'ajouter ce commentaire !');
            }
    }

    /**
     *valid comment admin
     *
     * @param [type] $commentId
     * @return void
     */
    public function validComment($commentId) 
    {
        if($this->commentsManager->validation($commentId)){
            header('Location: index.php?action=listCommentsAdmin');
        }else{
            throw new \Exception('Oups... Impossible de valider ce commentaire !');
        }
    }

    /**
     *valid article admin
     *
     * @param [type] $commentId
     * @return void
     */
    public function validArticle($articleId) 
    {
        if($this->articlesManager->validation($articleId)){
            header('Location: index.php?action=listArticlesAdmin');
        }else{
            throw new \Exception('Oups... Impossible de valider cet article !');
        }
    }

    /**
     * list articles admin
     *
     * @return void
     */
    public function listArticlesAdmin() 
    {
        if($articles = $this->articlesManager->getArticlesAdmin()){
            $this->adminTwig->addGlobal('session', $_SESSION);
            echo $this->adminTwig->render('listArticlesAdmin.html.twig',['articles' => $articles], ['droits' => $_SESSION == 1] );
        }else{
            throw new \Exception('Oups... Impossible d\'afficher les articles !');
        }
    }

    /**
     * list comments admin
     *
     * @return void
     */
    public function listCommentsAdmin()
    {
        if($comments = $this->commentsManager->getCommentsAdmin()){
            $this->adminTwig->addGlobal('session', $_SESSION);
            echo $this->adminTwig->render('listCommentsAdmin.html.twig',['comments' => $comments], ['droits' => $_SESSION == 1] );
        }else{
            throw new \Exception('Oups... Impossible d\'afficher les commentaires !');
        }
    }

    /**
     * confirm page delete article admin
     *
     * @return void
     */
    public function confirmdeletearticle ()
    {
        if($getId = $this->action->get('id')){
            $article = $this->articlesManager->Article($getId);
            $this->twigySecur->addGlobal('session', $_SESSION);
            echo $this->twigySecur->render('confirmdeletearticle.html.twig',['article' => $article], ['droits' => $_SESSION == 1]);
        }else{
            throw new \Exception('Oups... Impossible d\'afficher la confirmation de suppression !');
        }
    }

    /**
     * confirm page delete comment admin
     *
     * @return void
     */
    public function confirmdeletecomment ()
    {
        if($getId = $this->action->get('id')){
            $comment = $this->commentsManager->getComment($getId);
            $this->twigySecur->addGlobal('session', $_SESSION);
            echo $this->twigySecur->render('confirmdeletecomment.html.twig',['comment' => $comment], ['droits' => $_SESSION == 1]);
        }else{
            throw new \Exception('Oups... Impossible d\'afficher la confirmation de suppression !');
        }
        }

    /**
     * edit article admin
     *
     * @return void
     */
    public function editArticleAdmin()
    {
        if($getId = $this->action->get('id')){
        $articles = $this->articlesManager->getArticleAdmin($getId);
        $this->adminTwig->addGlobal('session', $_SESSION);
        echo $this->adminTwig->render("articleUpdating.html.twig", ['articles' => $articles], ['droits' => $_SESSION == 1]);
        }else{
            throw new \Exception('Impossible d\'éditer article!');
            }	 
    }

    /**
     * update article admin
     *
     * @param [type] $miniContent
     * @param [type] $title
     * @param [type] $content
     * @param [type] $postId
     * @return void
     */
    public function updateArticleAdmin($miniContent, $title, $content, $postId) 
    {
        if($this->articlesManager->updateArticle($miniContent, $title, $content, $postId)){
        header('Location: index.php?action=listArticlesAdmin');
    }else{
        throw new \Exception('Impossible de modifier cet article!');
        }
    }

    /**
     * delete article
     *
     * @param [type] $dataId
     * @return void
     */
    public function deleteArticle($dataId)
    {
        if($this->articlesManager->supprArticle($dataId)){
            header('Location: index.php?action=listArticlesAdmin');
            }else{
            throw new \Exception('Impossible de supprimer cet article!');
        }
    }

    /**
     * delete comment
     *
     * @param [type] $dataId
     * @return void
     */
    public function deleteComment($dataId)
    {
        if($this->commentsManager->supprComment($dataId)){
            header('Location: index.php?action=listCommentsAdmin');
            }else{
            throw new \Exception('Impossible de supprimer ce commentaire!');
        }
    }

    /**
     * display form to write article
     *
     * @return void
     */
    public function formArticle()
    {
        $this->adminTwig->addGlobal('session', $_SESSION);
        echo $this->adminTwig->render("articleWriting.html.twig",['droits' => $_SESSION == 1, 'droits' => $_SESSION == 2] );
    }  
    
    /**
     * send written article 
     *
     * @param [type] $idCategory
     * @param [type] $idUser
     * @param [type] $miniContent
     * @param [type] $title
     * @param [type] $content
     * @return void
     */
    public function articleWriting($idCategory, $idUser, $miniContent, $title, $content)
    {
        if($this->articlesManager->postArticle($idCategory, $idUser, $miniContent, $title, $content)){
            header('Location:index.php?action=listArticlesAdmin');
        }else{
            throw new \Exception('Impossible d \'ajouter un article...');
            }
    }
    
}