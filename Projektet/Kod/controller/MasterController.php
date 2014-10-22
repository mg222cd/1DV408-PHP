<?php
namespace Controller;

require_once("./View/NavigationView.php");
require_once("./Controller/LoginController.php");
require_once("./Controller/UserController.php");
require_once("./Controller/WorkoutController.php");

class MasterController{
//instances
private $loginController;
private $userController;
private $workoutController;

	public function __construct(){
		$this->loginController = new \Controller\LoginController();
		$this->userController = new \Controller\UserController();
	}

	/**
	* Maincontroller of the scenarios login, logout, registration and logged in.
	* Default page is the Login page
	*
	* @return string with HTML.
	*/
	public function controlNavigation(){
		switch (\View\NavigationView::getAction()) {
			case \View\NavigationView::$actionRegister:
				return $this->userController->controlRegistration();
				break;
			case \View\NavigationView::$actionLoggedIn:
				//security check:
				if ($this->loginController->validLogin() == TRUE) {
					$this->callWorkoutController();
					return $this->workoutController->doControl();
				}
				else{
					return $this->loginController->mainController();
				}
				break;
			case \View\NavigationView::$actionSignOut:
				$this->loginController->logoutTasks();
				return $this->loginController->mainController();
				break;
			default:
				if ($this->loginController->validLogin() == TRUE) {
					$this->callWorkoutController();
					return $this->workoutController->doControl();
				}
				else{
					return $this->loginController->mainController();
				}
				break;
		}
	}

	/**
	* Instance of WorkoutController-class is only declared if the login is secured as valid.
	*/
	public function callWorkoutController(){
		$this->workoutController = new \Controller\WorkoutController();
	}

}

