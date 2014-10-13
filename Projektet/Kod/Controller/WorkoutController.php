<?php
namespace Controller;

require_once("./Model/UserModel.php");
require_once("./View/WorkoutView.php");
require_once("./View/CookieView.php");
require_once("./Model/WorkoutRepository.php");

class WorkoutController{
	private $userModel;
	private $workoutView;
	private $cookieView;
	private $workoutRepo;
	private $username;
	private $userId;

	public function __construct(){
		$this->initialize();
	}
	
	public function doControl(){
		return $this->workoutView->userMenu($this->username);

	}

	private function setUsername(){ // flytta till konstruktor?
		$this->username = $this->userModel->setAndGetUsername();
	}

	private function initialize(){
		$this->userModel = new \Model\UserModel();
		$this->workoutView = new \View\WorkoutView();
		$this->cookieView = new \View\CookieStorage();
		$this->workoutRepo = new \Model\WorkoutRepository();
		//sets values to userId and username
		$this->setUsername();
		$this->userId = $this->userModel->getUserId($this->username);
		//show headermenu
		$this->workoutRepo->getAllWorkouts($this->userId);
	}
}