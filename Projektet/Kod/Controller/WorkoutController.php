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
	private $workoutPage;

	public function __construct(){
		$this->initialize();
	}
	
	public function doControl(){
		//show list on startpage
		$workoutList = $this->workoutRepo->getAllWorkouts($this->userId);
		$workoutListView = $this->workoutView->workoutList($workoutList);
		$this->workoutPage .= $workoutListView;
		return $this->workoutPage;

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
		$this->workoutPage = $this->workoutView->userMenu($this->username);
	}
}