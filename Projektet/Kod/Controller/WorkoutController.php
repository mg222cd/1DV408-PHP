<?php
namespace Controller;

require_once("./Model/UserModel.php");
require_once("./View/WorkoutView.php");
require_once("./View/CookieView.php");
require_once("./Model/WorkoutRepository.php");
require_once("./Model/WorkouttypeRepository.php");
require_once("./Model/WorkoutModel.php");

class WorkoutController{
	private $userModel;
	private $workoutView;
	private $cookieView;
	private $workoutRepo;
	private $workouttypeRepo;
	private $workoutModel;
	private $username;
	private $userId;
	private $workoutPage;


	public function __construct(){
		$this->userModel = new \Model\UserModel();
		$this->workoutView = new \View\WorkoutView();
		$this->cookieView = new \View\CookieStorage();
		$this->workoutRepo = new \Model\WorkoutRepository();
		$this->workouttypeRepo = new \Model\WorkouttypeRepository();
		$this->workoutModel = new \Model\WorkoutModel();
		$this->initialize();
	}
	
	public function doControl(){
		//add
		if ($this->workoutView->clickedAdd()) {
			//kontrollera ifyllda fält
			if (!$this->workoutView->isFilledDistance() || !$this->workoutView->isFilledMinutes()) {
				$this->workoutView->failRequiredFields();
			}
			else{
				$this->workoutView->clearMessage();
				//kontrollera validering...
				//...giltigt format på datum
				if (!$this->workoutModel->isShortDate($this->workoutView->getDateAdd())) {
			 		$this->workoutView->failDateFormat();
			 	}
			 	else{
			 		//...att distans...
			 		if (!$this->workoutModel->validateDistance($this->workoutView->getDistanceAdd())) {
			 			$this->workoutView->failDistanceFormat();
			 		}
			 	} 

			}
			
			
			
			//...och tid är heltal och av rätt längd. 
			//...och köra en strip_tags() på fritextfält?
			//...säkerhetskontroll att alla fält är ifyllda fortf
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