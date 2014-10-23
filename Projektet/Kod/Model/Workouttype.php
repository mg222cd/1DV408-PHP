<?php
namespace Model;

class Workouttype{
	//columns in table "workouttype"
	private $workoutTypeId;
	private $name;

	//setters
	public function __construct($workoutTypeId, $name){
		$this->workoutTypeId = $workoutTypeId;
		$this->name = $name;
	}

	//getters
	public function getWorkoutTypeId(){
		return $this->workoutTypeId;
	}

	public function getName(){
		return $this->name;
	}
}