<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\{ArticlesManager, CommentsManager};

class ControllerArticles{

    /**
     * listing articles
     *
     * @return void
     */
    public function listArticle() {

        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/articles');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $articlesManager = new ArticlesManager();
        $articles = $articlesManager->getArticles();
       
        $twig->addGlobal('session', $_SESSION);   
        echo $twig->render('articles.html.twig',['articles' => $articles], ['droits' => $_SESSION == 1]);
    
        
        //var_dump($articles); die;
    }

    /**
     * getting article and his comments
     *
     * @return void
     */
    public function getArticle(){
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/articles');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);

        $twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $articlesManager = new ArticlesManager();
        $article = $articlesManager->Article($_GET['id']);

     
        
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getComments($_GET['id']);
        
        $twig->addGlobal('session', $_SESSION); 
       
        
        //var_dump($comment); die;
        //echo $twig->render('article.html.twig',['article' => $article], ['comments' => $comments],  ['droits' => $_SESSION == 1]);
        
        
        require ('../views/templates/debug.php');
        
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

        if ($affectedLines === false)
        { 
            throw new \Exception('Oups... Impossible d\'ajouter ce commentaire !');
            
        }
        else
        {
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

        if ($signal === false)
        {
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
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $articlesManager = new ArticlesManager();
        $articles = $articlesManager->getArticles();
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render('listArticlesAdmin.html.twig',['articles' => $articles], ['droits' => $_SESSION == 1] );
    }

    /**
     * list comments admin
     *
     * @return void
     */
    public function listCommentsAdmin()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $commentsManager = new CommentsManager();
        $comments = $commentsManager->getCommentsAdmin();
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render('listCommentsAdmin.html.twig',['comments' => $comments], ['droits' => $_SESSION == 1] );
    }

    /**
     * confirm page delete article admin
     *
     * @return void
     */
    public function confirmdeletearticle ()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/security');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
        $articlesManager = new ArticlesManager();
        $article = $articlesManager->Article($_GET['id']);

        $twig->addGlobal('session', $_SESSION); 
     
    
        echo $twig->render('confirmdeletearticle.html.twig',['article' => $article], ['droits' => $_SESSION == 1]);
    }

    /**
     * edit article admin
     *
     * @return void
     */
    public function editArticleAdmin(){
        $articleManager = new ArticlesManager();
        $articles = $articleManager->getArticleAdmin($_GET['id']);
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render("articleUpdating.html.twig", ['articles' => $articles], ['droits' => $_SESSION == 1]);	 
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
        $supprime = new ArticlesManager();
        $deletedarticle = $supprime->supprArticle($dataId);

        if ($deletedarticle === false)
        {
            throw new \Exception('Impossible de supprimer cet article!');
        }
        else
        {
            header('Location: index.php?action=listArticlesAdmin');
        }
    }

    /**
     * display form to write article
     *
     * @return void
     */
    public function formArticle()
    {
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
        $twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render("articleWriting.html.twig",['droits' => $_SESSION == 1] );	 
            
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
        
        if ($createarticle === false)
        {
            throw new \Exception('Impossible d \'ajouter un article...');

        }else
            {
                header('Location:index.php?action=homePage');
            }
        }

}
