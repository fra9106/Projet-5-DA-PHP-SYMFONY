<?php

namespace Mod;

require '../vendor/autoload.php';

use Mod\Manager;

class ArticlesManager extends Manager
{
    /**
     * get articles list
     *
     * @return void
     */
    public function getArticles()
    {
        $db = $this->dbConnect();
		$articles = $db->prepare('SELECT categories.id, categories.category, articles.id, users.pseudo, articles.mini_content, articles.title, articles.content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr, DATE_FORMAT(update_date, \'%d/%m/%Y à %Hh%imin%ss\') AS update_date_fr FROM articles INNER JOIN users ON articles.id_user = users.id INNER JOIN categories ON articles.id_category = categories.id AND valid = 1 ORDER BY creation_date_fr DESC');
        $articles->execute(array());
        return $articles;
    }

    /**
     * get articles list admin
     *
     * @return void
     */
    public function getArticlesAdmin()
    {
        $db = $this->dbConnect();
		$articles = $db->prepare('SELECT categories.id, categories.category, articles.id, users.pseudo, articles.mini_content, articles.title, articles.content, articles.valid, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr, DATE_FORMAT(update_date, \'%d/%m/%Y à %Hh%imin%ss\') AS update_date_fr FROM articles INNER JOIN users ON articles.id_user = users.id INNER JOIN categories ON articles.id_category = categories.id ORDER BY creation_date_fr DESC');
        $articles->execute(array());
        return $articles;
    }

    

    /**
     * get articles by categories
     *
     * @param [type] $idCategory
     * @return void
     */
    public function getArticlesByCat($idCategory)
    {
        $db = $this->dbConnect();
		$articles = $db->prepare('SELECT categories.id, categories.category, articles.id, users.pseudo, articles.mini_content, articles.title, articles.content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr, DATE_FORMAT(update_date, \'%d/%m/%Y à %Hh%imin%ss\') AS update_date_fr FROM articles INNER JOIN users ON articles.id_user = users.id INNER JOIN categories ON articles.id_category = categories.id WHERE id_category = ? AND valid = 1 ORDER BY creation_date_fr DESC');
        $articles->execute(array($idCategory));
        
        return $articles;
    }


    /**
     * get article by id
     *
     * @param [type] $idArticle
     * @return void
     */
    public function Article($idArticle)
    {
        $db = $this->dbConnect();
		$req = $db->prepare('SELECT articles.id, users.pseudo, articles.mini_content, articles.title, articles.content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr, DATE_FORMAT(update_date, \'%d/%m/%Y à %Hh%imin%ss\') AS update_date_fr  FROM articles INNER JOIN users ON articles.id_user = users.id  WHERE articles.id = ?');
		$req->execute(array($idArticle));
        $article = $req->fetch();
        return $article;
    }

    /**
     * get article admin
     *
     * @param [type] $dataId
     * @return void
     */
    public function getArticleAdmin($dataId) 
	{
		$db = $this->dbConnect();
    	$articles = $db->prepare('SELECT id, mini_content, title, content, DATE_FORMAT(creation_date, \'%d/%m/%Y à %Hh%imin%ss\') AS creation_date_fr FROM articles WHERE id = ?');
        $articles->execute(array($dataId));
        return $articles;
    } 

    /**
	 * articles editor validation
	 *
	 * @param [type] $commentId
	 * @return void
	 */
	public function validation($articleId)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('UPDATE articles SET valid = 1 WHERE id = ?');
		$req->execute(array($articleId));
		return $req;
	}
    
    /**
     * update article
     *
     * @param [type] $miniContent
     * @param [type] $title
     * @param [type] $content
     * @param [type] $postId
     * @return void
     */
    public function updateArticle($miniContent, $title, $content, $postId)
    {
    	$db = $this->dbConnect();
		$updArticle = $db->prepare('UPDATE articles SET mini_content = ?, title = ?, content = ?, update_date = NOW()  WHERE id = ?');
        $artOk = $updArticle->execute(array($miniContent, $title, $content, $postId));
		return $artOk;
    }

    /**
     * delete article and his comments
     *
     * @param [type] $dataId
     * @return void
     */
    public function supprArticle($dataId)
	{ 
        $db = $this->dbConnect();
        $comment = $db->prepare('DELETE FROM comments WHERE id_article = ?');
        $comment->execute([$dataId]);
        $req = $db->prepare('DELETE FROM articles WHERE id = ?');
        $req->execute(array($dataId));
       	return $req;
    }
    
    /**
     * post article admin
     *
     * @param [type] $idCategory
     * @param [type] $idUser
     * @param [type] $miniContent
     * @param [type] $title
     * @param [type] $content
     * @return void
     */
    public function postArticle($idCategory, $idUser, $miniContent, $title, $content)
	{
		$db = $this->dbConnect();
		$inserarticle = $db->prepare('INSERT INTO articles(id_category, id_user, mini_content, title, content, creation_date) VALUES (?, ?, ?, ?, ?, NOW())');
        $article = $inserarticle->execute(array($idCategory, $idUser, $miniContent, $title, $content));
		return $article;
    }
}

