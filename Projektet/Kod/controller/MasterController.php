<?php
namespace Controller;

require_once("./Controller/LoginController.php");

class MasterController{

private $loginController;
/**
 * Creates new instances of loginview, 
 */
public function __construct(){
	$this->loginController = new \Controller\LoginController();
}
	/** 
 	 * Determinds the page content depending on URL
	 *
 	 * @return string (generatet from different view-functions)
	 */ 
	public function controlNavigation(){

		if (isset($_GET['Register'])) {
			return $this->loginController->doControl();
		}
		if (isset($_GET['LoggedIn'])) {
			return $this->navigationController->dontKnowGoodName();
		}
		if (isset($_GET['SignOut'])) {
			return $this->loginController->doControl();
		} 
		else {
			return $this->loginController->doControl();
		}
		
	}

}

