<?php

namespace Control;

require '../vendor/autoload.php';

use Mod\ArticlesManager;




class ControllerArticles{

    public function listArticle() {

        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/articles');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        	 

        $articlesManager = new ArticlesManager();
        $artic = $articlesManager->getArticles(); 
        //var_dump($artic); die;
            
        echo $twig->render("articles.html.twig");
    
    
    }


    public function formArticle(){
            
        $loader = new \Twig\Loader\FilesystemLoader('../views/templates/articles');
        $twig = new \Twig\Environment($loader, [
            'cache' => false
        ]);
		$twig = new \Twig\Environment($loader, ['debug' => true]);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());
        
        echo $twig->render("articleWriting.html.twig");	 
        
    }  
    
    public function articleWriting($idCategory, $idUser, $miniContent, $title, $content){
    $articleEdit = new ArticlesManager(); 
    $createarticle = $articleEdit->postArticle($idCategory, $idUser, $miniContent, $title, $content);
    if ($createarticle === false)
    {
        throw new \Exception('Impossible d \'ajouter un article...');

    }else
        {
            header('Location: index.php?action=homePage');
        }
    }

}
