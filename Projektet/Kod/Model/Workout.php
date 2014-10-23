<?php

namespace Model;

class Workout{
	//columns in the table "workout" (except workoutTypeName, which is from table "workouttype")
	private $workoutId;
	private $userId;
	private $workoutTypeId;
	private $wdate;
	private $distance;
	private $wtime;
	private $comment;
	private $workoutTypeName;
	
	//setters
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

	//getter
	public function getWorkoutId(){
		return $this->workoutId;
	}
	//getter
	public function getUserId(){
		return $this->userId;
	}
	//getter
	public function getWorkoutTypeId(){
		return $this->workoutTypeId;
	}
	//getter
	public function getDate(){
		return $this->wdate;
	}
	//getter
	public function getDistance(){
		return $this->distance;
	}
	//getter
	public function getTime(){
		return $this->wtime;
	}
	//getter
	public function getComment(){
		return $this->comment;
	}
	//getter
	public function getWorkoutTypeName(){
		return $this->workoutTypeName;
	}
	/**
	* Calculator-function, using fields distance and time, it calculates avarage time/km
	*
	* @return string $average
	*/
	public function getAverage(){
		$time = $this->wtime;
		$explodedTime = explode(":", $time);
		$hours = $explodedTime[0];
		$minutes = $explodedTime[1];
		$seconds = $explodedTime[2];
		$totalTimeInSeconds =  ($hours*3600) + ($minutes*60) + $seconds;
		$timePerKilometerInSeconds = $totalTimeInSeconds / $this->distance;
		$hoursWithDec = $timePerKilometerInSeconds / 3600;
		$hours = floor($hoursWithDec);
		$hours = strlen($hours)<2 ? $hours='0'.$hours : $hours=$hours;
		$totalTimeInSecondsMinusHours = $timePerKilometerInSeconds - ($hours*3600);
		$minutesWithDec = $totalTimeInSecondsMinusHours / 60;
		$minutes = floor($minutesWithDec);
		$minutes = strlen($minutes)<2 ? $minutes='0'.$minutes : $minutes=$minutes;
		$seconds = round($timePerKilometerInSeconds - ($hours*3600) - ($minutes*60));
		$seconds = strlen($seconds)<2 ? $seconds='0'.$seconds : $seconds=$seconds;
		$average = $hours . ":" . $minutes . ":" . $seconds;
		return $average;
	}

}