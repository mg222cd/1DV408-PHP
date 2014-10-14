<?php
namespace Model;

class Workouttype{
	private $workoutId;
	private $name;

	public function __construct($workoutId, $name){
		$this->workoutId = $workoutId;
		$this->name = $name;
	}

	public function getWorkoutId(){
		return $this->workoutId;
	}

	public function getName(){
		return $this->name;
	}
}