<?php
namespace Mod;

require '../vendor/autoload.php';


use Mod\Manager;

class CommentsManager extends Manager{

	/**
	 * gets comments with article id
	 *
	 * @param [type] $idArticle
	 * @return void
	 */
    public function getComments($idArticle)
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('SELECT comments.id, comments.id_article, users.pseudo, comments.content, comments.valid, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments INNER JOIN users ON comments.id_user = users.id WHERE id_article  = :id_article ORDER BY comment_date DESC');
		$comments->execute(array('id_article' => $idArticle));
		//$comment = $comments->fetch();
		//var_dump($comments); die;
		return $comments;
    }
 
	/**
	 * post comment
	 *
	 * @param [type] $idArticle
	 * @param [type] $idUser
	 * @param [type] $content
	 * @return void
	 */
    public function postComment($idArticle, $idUser, $content)
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('INSERT INTO comments(id_article, id_user, content, comment_date) VALUES( ?, ?, ?, NOW())');
		$affectedLines = $comments->execute(array($idArticle, $idUser, $content));

		return $affectedLines;
	}

	/**
	 * get comments admin
	 *
	 * @return void
	 */
	public function getCommentsAdmin()
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('SELECT comments.id, users.pseudo, comments.content, comments.valid, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments INNER JOIN users ON comments.id_user = users.id  ORDER BY comment_date DESC');
		$comments->execute(array());
		
		return $comments;
    }



}

