<?php

namespace Control;

require 'vendor/autoload.php';

use Mod\ArticlesManager;




class ControllerArticles{

    public function listArticles() {

        $loader = new \Twig\Loader\FilesystemLoader('views/frontend');
		$twig = new \Twig\Environment($loader);	
        $twig->addExtension(new \Twig\Extension\DebugExtension());

        	 

        $articlesManager = new ArticlesManager();
        $artic = $articlesManager->getArticles(); 
        return $artic;
        echo $twig->render("article.html.twig");
    
    
    }


    public function formArticle(){
            
        $loader = new \Twig\Loader\FilesystemLoader('views/frontend');
		$twig = new \Twig\Environment($loader);	
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
            header('Location: index.php?action=home.html.twig');
        }
    }

}
