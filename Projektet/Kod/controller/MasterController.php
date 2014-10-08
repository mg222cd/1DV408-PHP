<?php
namespace Controller;

require_once("./View/LoginView.php");

class MasterController{
private $loginView;

/**
 * Creates new instances of loginview, 
 */
public function __construct(){
	$this->loginView = new \View\LoginView();
}
	/** 
 	 * Determinds the page content
	 *
 	 * @return string (generatet from different view-functions)
	 */ 
	public function controlNavigation(){
		
		return $this->loginView->loginForm();
	}

}

