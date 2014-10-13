<?php
namespace Model;

require_once("./Model/DatabaseConnection.php");
require_once("./Model/Workout.php");

class WorkoutRepository extends DatabaseConnection{
	private $workoutList = array();
	private static $workoutId = 'workoutId';
	private static $userId = 'userId';
	private static $workoutTypeId = 'workoutTypeId';
	private static $date = 'date';
	private static $distance = 'distance';
	private static $time = 'time';
	private static $comment ='comment';
	
	public function __construct(){
		$this->dbTable = 'workout';
	}

	/**
	* Pickup all workouts to a specific user
	*
	* @param int $userId
	* @return Workout $WorkoutList
	*/
	public function getAllWorkouts($userId){
		try{
			$db = $this->connection();
			$sql = "SELECT * FROM $this->dbTable WHERE userId = :userId";
			$params = array(':userId' => $userId);

			$query = $db->prepare($sql);
			$query->execute($params);

			/*
			$sql = "SELECT * FROM $table WHERE username = :username;";
			$params = array(':username' => $userId);

			$query = $db->prepare($sql);
			$query->excute($params);
		*/

			foreach ($query->fetchAll() as $workout) {
				$workoutId = $workout['workoutId'];
				$userId = $workout['userId'];
				$workoutTypeId = $workout['workoutTypeId'];
				$date = $workout['date'];
				$distance = $workout['distance'];
				$time = $workout['time'];
				$comment = $workout ['comment'];
				$this->workoutList[] = new \Model\Workout($workoutId, $userId, $workoutTypeId, $date, $distance, $time, $comment);
			}
			return $this->workoutList;
		}
		catch(\PDOException $e){
			//throw new \Exception('Fel uppstod i samband med hämtning av träningspass från databasen.');
			echo '<pre>';
			var_dump($e);
			echo '</pre>';

			die('Error while connection to database.');
		}
	}
}