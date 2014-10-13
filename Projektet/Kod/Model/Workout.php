<?php

namespace Model;

class Workout{
	private $workoutId;
	private $userId;
	private $workoutTypeId;
	private $wdate;
	private $distance;
	private $wtime;
	private $comment;
	private $workoutTypeName;
	
	public function __construct($workoutId, $userId, $workoutTypeId, $wdate, $distance, $wtime, $comment, $workoutTypeName){
		$this->workoutId = $workoutId;
		$this->userId = $userId;
		$this->workoutTypeId = $workoutTypeId;
		$this->wdate = $wdate;
		$this->distance = $distance;
		$this->wtime = $wtime;
		$this->comment = $comment;
		$this->workoutTypeName = $workoutTypeName;
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
		return $this->wdate;
	}

	public function getDistance(){
		return $this->distance;
	}

	public function getTime(){
		return $this->wtime;
	}

	public function getComment(){
		return $this->comment;
	}

	public function getWorkoutTypeName(){
		return $this->workoutTypeName;
	}

	public function getAverage(){
		$newtime = $this->wtime - 50;
		return $newtime;
	}

}