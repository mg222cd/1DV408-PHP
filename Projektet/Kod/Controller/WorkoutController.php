<?php
namespace Controller;

require_once("./Model/UserModel.php");
require_once("./View/WorkoutView.php");
require_once("./View/CookieView.php");
require_once("./Model/WorkoutRepository.php");
require_once("./Model/WorkouttypeRepository.php");

class WorkoutController{
	private $userModel;
	private $workoutView;
	private $cookieView;
	private $workoutRepo;
	private $workouttypeRepo;
	private $username;
	private $userId;
	private $workoutPage;


	public function __construct(){
		$this->userModel = new \Model\UserModel();
		$this->workoutView = new \View\WorkoutView();
		$this->cookieView = new \View\CookieStorage();
		$this->workoutRepo = new \Model\WorkoutRepository();
		$this->workouttypeRepo = new \Model\WorkouttypeRepository();
		$this->initialize();
	}
	
	public function doControl(){
		//add
		if ($this->workoutView->clickedAdd()) {
			$this->workoutPage .= $this->workoutView->addWorkoutForm($this->workouttypeRepo->getAll());
			return $this->workoutPage;
		}
		//delete
		//update
		//annars:
		return $this->showList();
		//return $this->workouttypeRepo->getAll();
	}

	public function showList(){
		$workoutList = $this->workoutRepo->getAllWorkouts($this->userId);
		$workoutListView = $this->workoutView->workoutList($workoutList);
		$this->workoutPage .= $workoutListView;
		return $this->workoutPage;
	}

	private function setUsername(){ // flytta till konstruktor?
		$this->username = $this->userModel->setAndGetUsername();
	}

	private function initialize(){
		//sets values to userId and username
		$this->setUsername();
		$this->userId = $this->userModel->getUserId($this->username);
		$this->workoutPage = $this->workoutView->userMenu($this->username);
	}
}