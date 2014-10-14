<?php
namespace Model;

class Workouttype{
	private $workoutTypeId;
	private $name;

	public function __construct($workoutTypeId, $name){
		$this->workoutTypeId = $workoutTypeId;
		$this->name = $name;
	}

	public function getWorkoutTypeId(){
		return $this->workoutTypeId;
	}

	public function getName(){
		return $this->name;
	}
}