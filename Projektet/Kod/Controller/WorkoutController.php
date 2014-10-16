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
			if ($this->validateInputs() == TRUE) {
				$userId = $this->userId;
				$workoutTypeId = $this->workoutView->getTypeAdd();
				$wdate = $this->workoutView->getDateAdd();
				$distance = $this->workoutView->getDistanceAdd();
				$wtime = $this->workoutView->getTimeAdd();
				$comment = $this->workoutView->getCommentAdd();
				if ($this->workoutRepo->addWorkout($userId, $workoutTypeId, $wdate, $distance, $wtime, $comment) == TRUE) {
					header('Location: ./');
					die();
				}
			}
			$this->workoutPage .= $this->workoutView->addWorkoutForm($this->workouttypeRepo->getAll());
			return $this->workoutPage;
		}
		//
		//delete
		//update
		//annars:
		
		return $this->showList();
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

	private function validateInputs(){
		//kontrollera ifyllda fält
		if (!$this->workoutView->isFilledDistance() || !$this->workoutView->isFilledMinutes() || !$this->workoutView->isFilledType()) {
			$this->workoutView->failRequiredFields();
			return FALSE;
		}
		else{
			$this->workoutView->clearMessage();
			//kontrollera validering...
			//...datum
			if (!$this->workoutModel->isShortDate($this->workoutView->getDateAdd())) {
		 		$this->workoutView->failDateFormat();
		 		return FALSE;
		 	}
		 	else{
		 		//...distans
		 		if (!$this->workoutModel->validateDistance($this->workoutView->getDistanceAdd())) {
		 			$this->workoutView->failDistanceFormat();
		 			return FALSE;
		 		}
		 		//...tid (timmar, minuter, sekunder)
		 		$hours = $this->workoutView->getHoursAdd();
		 		$minutes = $this->workoutView->getMinutesAdd();
		 		$seconds = $this->workoutView->getSecondsAdd();
		 		if (!$this->workoutModel->validateTime($hours, $minutes, $seconds)) {
		 			$this->workoutView->failTimeFormat();
		 			return FALSE;
		 		}
		 		//...otillåtna tecken
		 		$strippedComment = $this->workoutModel->sanitizeText($this->workoutView->getCommentAdd());
                if ($strippedComment != NULL) {
                    $this->workoutView->failComment($strippedComment);
                    return FALSE;
                }
		 	}
		}
		return TRUE;
	}


}