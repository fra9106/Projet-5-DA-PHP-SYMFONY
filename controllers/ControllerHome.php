<?php
namespace Control;
require '../vendor/autoload.php';

use Mod\HomeManager;

class ControllerHome
{
	/**
	 * class properties
	 *
	 * @var [type]
	 */
	private $loader;
    private $twig;
    private $newMessage;

	/**
	 * builder
	 */
	public function __construct()
    {
        $this->loader = new \Twig\Loader\FilesystemLoader('../views/templates/home');
        $this->twig = new \Twig\Environment($this->loader);
        $this->newMessage = new HomeManager();
    }

	/**
	 * Display home page
	 * @return void
	 * */
	public function homePage()
	{
		$this->twig->addGlobal('session', $_SESSION);
		echo $this->twig->render("home.html.twig", ['session' => $_SESSION], ['droits' => $_SESSION == 1]);	 
	 }

	 /**
	 * Send data in database
	 * @return void
	 * */
	 public function sendMessage($username, $mail, $content)
	{
		$this->newMessage->addMessage($username, $mail, $content);
		header("Location:index.php?action=homePage");
	}

	public function legalPage()
	{
		require('../views/templates/legalNotice.php');
	}
}