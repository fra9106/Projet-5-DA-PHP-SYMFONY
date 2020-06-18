<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\{ArticlesManager, CommentsManager};

class ControllerArticles{

    

    public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../views/templates/articles');
        $this->twig = new \Twig\Environment($this->loader);
        $this->loadAdmin = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $this->adminTwig = new \Twig\Environment($this->loadAdmin);
        $this->loaderSecurit = new \Twig\Loader\FilesystemLoader('../views/templates/security');
        $this->twigySecur = new \Twig\Environment($this->loaderSecurit);
    }

    /**
     * listing articles
     *
     * @return void
     */
    public function listArticle() 
    {
        $articlesManager = new ArticlesManager();
        $articles = $articlesManager->getArticles();
       
        $this->twig->addGlobal('session', $_SESSION);   
        echo $this->twig->render('articles.html.twig',['articles' => $articles], ['droits' => $_SESSION == 1]);
    }

    /**
     * getting article and his comments
     *
     * @return void
     */
    public function getArticle()
    {
        

        $articlesManager = new ArticlesManager();
        $article = $articlesManager->Article($_GET['id']);
        
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getComments($_GET['id']);
        
        $this->twig->addGlobal('session', $_SESSION);
        echo $this->twig->render('article.html.twig',['comments' => $comments,'article' => $article],  ['droits' => $_SESSION == 1]);
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
        $commentsManager = new CommentsManager();
        $content = htmlspecialchars($content);
        $affectedLines = $commentsManager->postComment($idArticle, $_SESSION['id'], $content);

        if ($affectedLines === false){ 
            throw new \Exception('Oups... Impossible d\'ajouter ce commentaire !');
        }else{

            header('Location: index.php?action=getArticle&id=' . $idArticle);
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
        $commentManager = new CommentsManager();
        $signal = $commentManager->validation($commentId);

        if ($signal === false){
            throw new \Exception('Oups... Impossible de signaler ce commentaire !');
        }else{
            header('Location: index.php?action=listCommentsAdmin');
        }
    }

    /**
     * list articles admin
     *
     * @return void
     */
    public function listArticlesAdmin() 
    {
        $articlesManager = new ArticlesManager();
        $articles = $articlesManager->getArticles();

        $this->adminTwig->addGlobal('session', $_SESSION);
        echo $this->adminTwig->render('listArticlesAdmin.html.twig',['articles' => $articles], ['droits' => $_SESSION == 1] );
    }

    /**
     * list comments admin
     *
     * @return void
     */
    public function listCommentsAdmin()
    {
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getCommentsAdmin();

        $this->adminTwig->addGlobal('session', $_SESSION);
        echo $this->adminTwig->render('listCommentsAdmin.html.twig',['comments' => $comments], ['droits' => $_SESSION == 1] );
    }

    /**
     * confirm page delete article admin
     *
     * @return void
     */
    public function confirmdeletearticle ()
    {
        $articlesManager = new ArticlesManager();
        $article = $articlesManager->Article($_GET['id']);

        $this->twigySecur->addGlobal('session', $_SESSION);
        echo $this->twigySecur->render('confirmdeletearticle.html.twig',['article' => $article], ['droits' => $_SESSION == 1]);
    }

    /**
     * confirm page delete comment admin
     *
     * @return void
     */
    public function confirmdeletecomment ()
    {
        $commentManager = new CommentsManager();
        $comment = $commentManager->getComment($_GET['id']);

        $this->twigySecur->addGlobal('session', $_SESSION);
        echo $this->twigySecur->render('confirmdeletecomment.html.twig',['comment' => $comment], ['droits' => $_SESSION == 1]);
    }

    /**
     * edit article admin
     *
     * @return void
     */
    public function editArticleAdmin()
    {
        $articleManager = new ArticlesManager();
        $articles = $articleManager->getArticleAdmin($_GET['id']);
       
        $this->adminTwig->addGlobal('session', $_SESSION);
        echo $this->adminTwig->render("articleUpdating.html.twig", ['articles' => $articles], ['droits' => $_SESSION == 1]);	 
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
        $update = new ArticlesManager();
        $updatearticle = $update->updateArticle($miniContent, $title, $content, $postId);
        
        header('Location: index.php?action=listArticlesAdmin');
    }

    /**
     * delete article
     *
     * @param [type] $dataId
     * @return void
     */
    public function deleteArticle($dataId)
    {
        $delete = new ArticlesManager();
        $deletedarticle = $delete->supprArticle($dataId);

        if ($deletedarticle === false){
            throw new \Exception('Impossible de supprimer cet article!');
        }else{
            header('Location: index.php?action=listArticlesAdmin');
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
        $delete = new CommentsManager();
        $deletedarticle = $delete->supprComment($dataId);

        if ($deletedarticle === false){
            throw new \Exception('Impossible de supprimer ce commentaire!');
        }else{
            header('Location: index.php?action=listCommentsAdmin');
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
        echo $this->adminTwig->render("articleWriting.html.twig",['droits' => $_SESSION == 1] );	 
            
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
    public function articleWriting($idCategory, $idUser, $miniContent, $title, $content){
        $articleEdit = new ArticlesManager(); 
        $createarticle = $articleEdit->postArticle($idCategory, $idUser, $miniContent, $title, $content);
        
        if ($createarticle === false){
            throw new \Exception('Impossible d \'ajouter un article...');

        }else{
                header('Location:index.php?action=listArticlesAdmin');
            }
        }

}
