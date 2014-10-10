<?php
namespace Controller;

require_once("./View/NavigationView.php");
require_once("./Controller/LoginController.php");
require_once("./Controller/UserController.php");
require_once("./Controller/WorkoutController.php");

class MasterController{

private $loginController;
private $userController;
private $workoutController;


public function __construct(){
	$this->loginController = new \Controller\LoginController();
	$this->userController = new \Controller\UserController();
	$this->workoutController = new \Controller\WorkoutController();
}

	public function controlNavigation(){
		switch (\View\NavigationView::getAction()) {
			case \View\NavigationView::$actionRegister:
				return $this->userController->controlRegistration();
				break;
			case \View\NavigationView::$actionLoggedIn:
				return $this->workoutController->doControl();
				break;
			case \View\NavigationView::$actionSignOut:
				return $this->loginController->doControl();
				break;
			default:
				return $this->loginController->doControl();
				break;
		}
	}

}

