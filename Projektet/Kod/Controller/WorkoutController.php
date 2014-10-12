<?php
namespace Controller;

require_once("./Model/UserModel.php");
require_once("./View/WorkoutView.php");
require_once("./View/CookieView.php");

class WorkoutController{
	private $userModel;
	private $workoutView;
	private $cookieView;
	private $username = "hårdkodat namn";

	public function __construct(){
		$this->userModel = new \Model\UserModel();
		$this->workoutView = new \View\WorkoutView();
		$this->cookieView = new \View\CookieStorage();
	}

	private function setUsername(){
		$this->username = $this->userModel->setAndGetUsername();
	}
	
	public function doControl(){
		$this->setUsername();
		return $this->workoutView->userMenu($this->username);
	}
}