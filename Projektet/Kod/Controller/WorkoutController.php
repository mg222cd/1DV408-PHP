<?php
namespace Controller;

require_once("./Model/UserModel.php");

class WorkoutController{

	private $UserModel;

	public function __construct(){
		$this->userModel = new \Model\UserModel();
	}
	
	public function doControl(){
		echo "inne i WorkoutController!!";
	}
}