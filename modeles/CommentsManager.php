<?php
namespace Mod;

require '../vendor/autoload.php';


use Mod\Manager;

class CommentsManager extends Manager{

    public function getComments($idArticle)//méthode de récupération des commentaire avec une jointure dans la requete pour récupérer le pseudo de l'user
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('SELECT comments.id, comments.id_article, users.pseudo, comments.content, comments.valid, DATE_FORMAT(comment_date, \'%d/%m/%Y à %Hh%imin%ss\') AS comment_date_fr FROM comments INNER JOIN users ON comments.id_user = users.id WHERE id_article  = ? ORDER BY comment_date DESC');
		$comments->execute(array($idArticle));
		//$comment = $comments->fetch();
		//var_dump($comment); die;
		return $comments;
    }
    
    public function postComment($idArticle, $idUser, $content)//insertion des commentaires dans la table avis
	{
		$db = $this->dbConnect();
		$comments = $db->prepare('INSERT INTO comments(id_article, id_user, content, comment_date) VALUES( ?, ?, ?, NOW())');
		$affectedLines = $comments->execute(array($idArticle, $idUser, $content));

		return $affectedLines;
	}

}

