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
		$comments = $db->prepare('SELECT comments.id, comments.id_article, users.pseudo, comments.content, comments.valid, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments INNER JOIN users ON comments.id_user = users.id WHERE id_article = ? AND valid = 1 ORDER BY comment_date DESC');
		$comments->execute(array($idArticle));
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

	/**
	 * get comment 
	 *
	 * @return void
	 */
	public function getComment($idComment)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('SELECT * FROM comments WHERE id = ?');
		$req->execute(array($idComment));
		$comment = $req->fetch();
		return $comment;
	}

	
	/**
	 * comments validation
	 *
	 * @param [type] $commentId
	 * @return void
	 */
	public function validation($commentId) //requete pour signaler un commentaire (user)
	{
		$db = $this->dbConnect();
		$req = $db->prepare('UPDATE comments SET valid = 1 WHERE id = ?');
		$req->execute(array($commentId));

		return $req;
	}

	/**
     * delete comment
     *
     * @param [type] $dataId
     * @return void
     */
    public function supprComment($dataId)
	{ 
        $db = $this->dbConnect();
        $comment = $db->prepare('DELETE FROM comments WHERE id = ?');
        $comment->execute([$dataId]);
        
        return $comment;
    }



}

