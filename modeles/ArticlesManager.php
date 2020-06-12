<?php

namespace Mod;
require '../vendor/autoload.php';


use Mod\Manager;


class ArticlesManager extends Manager{

    public function getArticles(){

        $db = $this->dbConnect();
		$articles = $db->query('SELECT categories.id, categories.category, articles.id, users.pseudo, articles.mini_content, articles.title, articles.content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles INNER JOIN users ON articles.id_user = users.id INNER JOIN categories ON articles.id_category = categories.id ORDER BY creation_date_fr');
       
       return $articles;
        

    }

    public function postArticle($idCategory, $idUser, $miniContent, $title, $content)
	{
		$db = $this->dbConnect();
		$inserarticle = $db->prepare('INSERT INTO articles(id_category, id_user, mini_content, title, content, creation_date) VALUES (?, ?, ?, ?, ?, NOW())');
        $article = $inserarticle->execute(array($idCategory, $idUser, $miniContent, $title, $content));
		
		return $article;

	}
}