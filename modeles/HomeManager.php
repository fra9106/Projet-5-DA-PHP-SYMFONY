<?php
namespace Mod;
require '../vendor/autoload.php';

use Mod\Manager;

class HomeManager extends Manager
{
	public function addMessage($username,$mail,$content)
	{
		$db = $this->dbConnect();
        $insertMessage = $db->prepare("INSERT INTO homepage(username, mail, content) VALUES(?, ?, ?)");
        $insertMessage->execute(array($username, $mail, $content));
         
        return $insertMessage;
	}
}