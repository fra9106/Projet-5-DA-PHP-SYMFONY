<?php
namespace Control;
require '../vendor/autoload.php';

use Mod\HomeManager;



class ControllerHome
{
	/**
	 * Display home page
	 * @return void
	 * */

	public function homePage()
	{
		
		$loader = new \Twig\Loader\FilesystemLoader('../views/templates/home');
		$twig = new \Twig\Environment($loader);	
		    
		$twig->addGlobal('session', $_SESSION);

		echo $twig->render("home.html.twig", ['session' => $_SESSION['pseudo']]);	 
	 }

	 /**
	 * Send data in database
	 * @return void
	 * */
	 public function sendMessage($username, $mail, $content)
	{
		$newMessage = new HomeManager();
		$send = $newMessage->addMessage($username, $mail, $content);
		header("Location:index.php?action=homePage");

	}

			
	
}