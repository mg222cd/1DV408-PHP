<?php
namespace Controller;

require_once("./Model/UserModel.php");
require_once("./View/WorkoutView.php");
require_once("./View/CookieView.php");

class WorkoutController{
	private $userModel;
	private $workoutView;
	private $cookieView;
	private $username;
	private $userId;

	public function __construct(){
		$this->userModel = new \Model\UserModel();
		$this->workoutView = new \View\WorkoutView();
		$this->cookieView = new \View\CookieStorage();
		//sets values to userId and username
		$this->setUsername();
		$this->userId = $this->userModel->getUserId($this->username);
	}

	private function setUsername(){
		$this->username = $this->userModel->setAndGetUsername();
	}
	
	public function doControl(){
		return $this->workoutView->userMenu($this->username);
	}
}