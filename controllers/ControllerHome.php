<?php
namespace Control;



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

		echo $twig->render("home.html.twig");	 
	 
	
	}
			
	
}