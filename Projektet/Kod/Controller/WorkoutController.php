<?php
namespace Controller;

require_once("./Model/UserModel.php");
require_once("./View/WorkoutView.php");

class WorkoutController{
	private $userModel;
	private $workoutView;
	private $username;

	public function __construct($username){
		$this->userModel = new \Model\UserModel();
		$this->workoutView = new \View\WorkoutView();
		$this->username = $username;
	}
	
	public function doControl(){
		return $this->workoutView->userMenu($this->username);
	}
}