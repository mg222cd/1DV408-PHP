<?php
namespace Controller;

require_once("./Controller/LoginController.php");
require_once("./Controller/UserController.php");
require_once("./Controller/NavigationController.php");

class MasterController{

private $loginController;
private $userController;
private $navigationController;


public function __construct(){
	$this->loginController = new \Controller\LoginController();
	$this->userController = new \Controller\UserController();
	$this->navigationController = new \Controller\NavigationController();
}

	public function controlNavigation(){

		if (isset($_GET['Register'])) {
			return $this->userController->controlRegistration();
		}
		if (isset($_GET['LoggedIn'])) {
			return $this->navigationController->doControl();
		}
		if (isset($_GET['SignOut'])) {
			return $this->loginController->doControl();
		} 
		else {
			return $this->loginController->doControl();
		}
		
	}

}

