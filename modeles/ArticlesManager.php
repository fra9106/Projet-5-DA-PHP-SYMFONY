<?php

namespace Mod;
require '../vendor/autoload.php';


use Mod\Manager;


class ArticlesManager extends Manager{

    public function getArticles(){

        $db = $this->dbConnect();
		$articles = $db->query('SELECT categories.id, categories.category, articles.id, users.pseudo, articles.mini_content, articles.title, articles.content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles INNER JOIN users ON articles.id_user = users.id INNER JOIN categories ON articles.id_category = categories.id ORDER BY creation_date_fr DESC');
       
       return $articles;
        

    }

    public function Article($idArticle){
        $db = $this->dbConnect();
		$req = $db->prepare('SELECT categories.id, categories.category, articles.id, users.pseudo, articles.mini_content, articles.title, articles.content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles INNER JOIN users ON articles.id_user = users.id INNER JOIN categories ON articles.id_category = categories.id'); 
		$req->execute(array($idArticle));
		$articles = $req->fetch();
		return $articles;
    }

    public function getArticleAdmin($dataId) // méthode de récupération article à modifier (admin)
	{
		
		$db = $this->dbConnect();
    	$articles = $db->prepare('SELECT id, mini_content, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles WHERE id = ?');
		$articles->execute(array($dataId));
	
    	return $articles;
    } 
    
    public function updateArticle($miniContent, $title, $content, $postId) //modifie article (admin)
    {
    	$db = $this->dbConnect();
		$updArticle = $db->prepare('UPDATE articles SET mini_content = ?, title = ?, content = ?, creation_date = NOW() WHERE id = ?');
        $artOk = $updArticle->execute(array($miniContent, $title, $content, $postId));
		return $artOk;
    }

    public function supprArticle($dataId) //supprime un article et ses commentaires (admin)
	{ 
        $db = $this->dbConnect();
        /*$comment = $db->prepare('DELETE FROM avis WHERE id_article = ?');
        $comment->execute([$dataId]);*/
        $req = $db->prepare('DELETE FROM articles WHERE id = ?');
        $req->execute(array($dataId));
       	return $req;
    }
    

    public function postArticle($idCategory, $idUser, $miniContent, $title, $content)
	{
		$db = $this->dbConnect();
		$inserarticle = $db->prepare('INSERT INTO articles(id_category, id_user, mini_content, title, content, creation_date) VALUES (?, ?, ?, ?, ?, NOW())');
        $article = $inserarticle->execute(array($idCategory, $idUser, $miniContent, $title, $content));
		
		return $article;

	}
}