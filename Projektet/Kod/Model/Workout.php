<?php

namespace Model;

class Workout{
	private $workoutId;
	private $userId;
	private $workoutTypeId;
	private $date;
	private $distance;
	private $time;
	private $comment;
	
	public function __construct($workoutId, $userId, $workoutTypeId, $date, $distance, $time, $comment){
		$this->workoutId = $workoutId;
		$this->userId = $userId;
		$this->workoutTypeId = $workoutTypeId;
		$this->date = $date;
		$this->distance = $distance;
		$this->time = $time;
		$this->comment = $comment;
	}

	public function getWorkoutId(){
		return $this->workoutId;
	}

	public function getUserId(){
		return $this->userId;
	}

	public function getWorkoutTypeId(){
		return $this->workoutTypeId;
	}

	public function getDate(){
		return $this->date;
	}

	public function getDistance(){
		return $this->distance;
	}

	public function getTime(){
		return $this->time;
	}

	public function getComment(){
		return $this->comment;
	}
}