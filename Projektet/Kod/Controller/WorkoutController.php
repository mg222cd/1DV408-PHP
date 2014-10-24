<?php
namespace Controller;

require_once("./Model/UserModel.php");
require_once("./View/WorkoutView.php");
//require_once("./View/CookieView.php");
require_once("./Model/WorkoutRepository.php");
require_once("./Model/WorkouttypeRepository.php");
require_once("./Model/WorkoutModel.php");

class WorkoutController{
	private $userModel;
	private $workoutView;
	//private $cookieView;
	private $workoutRepo;
	private $workouttypeRepo;
	private $workoutModel;
	private $username;
	private $userId;
	private $workoutPage;


	public function __construct(){
		$this->userModel = new \Model\UserModel();
		$this->workoutView = new \View\WorkoutView();
		//$this->cookieView = new \View\CookieStorage();
		$this->workoutRepo = new \Model\WorkoutRepository();
		$this->workouttypeRepo = new \Model\WorkouttypeRepository();
		$this->workoutModel = new \Model\WorkoutModel();
		$this->initialize();
	}

	/**
	* Maincontroller for CRUD-scenarios
	*
	* @return string with HTML
	*/
	public function doControl(){
		//ADD
		if ($this->workoutView->clickedAdd()) {
			if ($this->validateInputs() == TRUE) {
				$userId = $this->userId;
				$workoutTypeId = $this->workoutView->getTypeAdd();
				$wdate = $this->workoutView->getDateAdd();
				$wdate = $this->workoutModel->validateDate($wdate);
				$distance = $this->workoutView->getDistanceAdd();
				$wtime = $this->workoutView->getTimeAdd();
				var_dump($wtime);
				$comment = $this->workoutView->getCommentAdd();
				if ($this->workoutRepo->addWorkout($userId, $workoutTypeId, $wdate, $distance, $wtime, $comment) == TRUE) {
					$this->workoutView->succeedAdd();
					header('Location: ./');
					die();
				}
			}
			$this->workoutPage .= $this->workoutView->addWorkoutForm($this->workouttypeRepo->getAll());
			return $this->workoutPage;
		}
		//DELETE
		if (!is_null($this->workoutView->getDelete())) {
			$this->workoutView->confirmDelete();
			if ($this->workoutView->getConfirm()) {
				if ($this->workoutRepo->deleteWorkout($this->workoutView->getDelete(), $this->userId)) {
					$this->workoutView->succeedDelete();
					header('Location: ./');
					die();
				}
				else{
				$this->workoutView->failDelete();
				header('Location: ./');
				die();
				}
			}
		}
		//UPDATE
		if (!is_null($this->workoutView->getUpdate())) {
			//pickup selected row from database
			$workoutToUpdate = $this->workoutRepo->certificatedToUpdate($this->workoutView->getUpdate(), $this->userId);
			//security check that user is certified selected id, and it's not manipulated
			if (!$workoutToUpdate) {
				$this->workoutView->failUpdate();
				header('Location: ./');
				die();
			} 
			else {
				//if ($this->workoutView->clickedChange() || !is_null($this->workoutView->getUpdate())) {
				//visa formulär med alla värden ifyllda.
				if ($this->validateInputs() == TRUE) {
					//values to add
					$workoutId = $this->workoutView->getUpdate();
					$userId = $this->userId;
					$workoutTypeId = $this->workoutView->getTypeAdd();
					$wdate = $this->workoutView->getDateAdd();
					$distance = $this->workoutView->getDistanceAdd();
					$wtime = $this->workoutView->getTimeAdd();
					$comment = $this->workoutView->getCommentAdd();
					if ($this->workoutRepo->updateWorkout($workoutId, $userId, $workoutTypeId, $wdate, $distance, $wtime, $comment) == TRUE) {
						$this->workoutView->succeedUpdate();
						header('Location: ./');
						die();
					}
				}
				$this->workoutPage .= $this->workoutView->changeWorkoutForm($workoutToUpdate, $this->workouttypeRepo->getAll());
			}
			return $this->workoutPage;
		}
		//COPY
		if (!is_null($this->workoutView->getCopy())) {
			//selected row to copy from DB
			$workoutToCopy = $this->workoutRepo->certificatedToUpdate($this->workoutView->getCopy(), $this->userId);
			if (!$workoutToCopy) {
				$this->workoutView->failCopy();
				header('Location: ./');
				die();
			}
			else{
				$this->workoutPage .= $this->workoutView->copyWorkoutForm($workoutToCopy, $this->workouttypeRepo->getAll());
			}
			return $this->workoutPage;
		}
		//DEFAULT
		return $this->showList();
	}

	/**
	* Function to generate workout-list
	*
	*	@return string with HTML
	*/
	public function showList(){
		$workoutList = $this->workoutRepo->getAllWorkouts($this->userId);
		$workoutListView = $this->workoutView->workoutList($workoutList);
		$this->workoutPage .= $workoutListView;
		return $this->workoutPage;
	}

	/**
	* Function to set username from logged in user (using session from user model)
	*/
	private function setUsername(){ 
		$this->username = $this->userModel->setAndGetUsername();
	}

	/**
	* Random things to when the startpage is loaded
	*/
	private function initialize(){
		//sets values to userId and username
		$this->setUsername();
		$this->userId = $this->userModel->getUserId($this->username);
		$this->workoutPage = $this->workoutView->userMenu($this->username);
	}

	/**
	* Validator-function, used from ADD, UPDATE, DELETE-forms
	*
	* @return bool
	*/
	private function validateInputs(){
		//required fields...
		if (!$this->workoutView->isFilledDistance() || $this->workoutView->getTimeAdd() == '00:00:00' || !$this->workoutView->isFilledType()) {
			$this->workoutView->failRequiredFields();
			return FALSE;
		}
		else{
			$this->workoutView->clearMessage();
			//validation...
			//...date-field
			if (!$this->workoutModel->isShortDate($this->workoutView->getDateAdd())) {
		 		$this->workoutView->failDateFormat();
		 		return FALSE;
		 	}
		 	else{
		 		//...distance-field
		 		if (!$this->workoutModel->validateDistance($this->workoutView->getDistanceAdd())) {
		 			$this->workoutView->failDistanceFormat();
		 			return FALSE;
		 		}
		 		//...time-fields
		 		$hours = $this->workoutView->getHoursAdd();
		 		$minutes = $this->workoutView->getMinutesAdd();
		 		$seconds = $this->workoutView->getSecondsAdd();
		 		if (!$this->workoutModel->validateTime($hours, $minutes, $seconds)) {
		 			$this->workoutView->failTimeFormat();
		 			return FALSE;
		 		}
		 		//...comment-field
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