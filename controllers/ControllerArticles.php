<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\{ArticlesManager, CommentsManager};




class ControllerArticles{

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

    public function getArticle(){
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/articles');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);

        $twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        $articlesManager = new ArticlesManager();
        $commentsManager = new CommentsManager();

        $article = $articlesManager->Article($_GET['id']);
        
        $comment = $commentsManager->getComments($_GET['id']);
        //var_dump($comment); die;
        $twig->addGlobal('session', $_SESSION); 
       // $valid = 'valid';  
       
        echo $twig->render('article.html.twig',['article' => $article],['droits' => $_SESSION == 1],['comment' => $comment]);
       
        //, ['valid' => $valid == 1]

    }

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




    public function listArticlesAdmin() {

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

    public function updateArticleAdmin($miniContent, $title, $content, $postId) // modifie article
    
    {
        $update = new ArticlesManager();
        $updatearticle = $update->updateArticle($miniContent, $title, $content, $postId);
        
        header('Location: index.php?action=listArticlesAdmin');
    }

    public function deleteArticle($dataId) // supprimme l'article
    
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



    public function formArticle(){
            
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/admin');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        $twig->addGlobal('session', $_SESSION);
        echo $twig->render("articleWriting.html.twig",['droits' => $_SESSION == 1] );	 
        
    }  
    
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
