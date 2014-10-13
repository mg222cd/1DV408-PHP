<?php
namespace Model;

require_once("./Model/DatabaseConnection.php");
require_once("./Model/Workout.php");

class WorkoutRepository extends DatabaseConnection{
	private static $workoutId = 'workoutId';
	private static $userId = 'userId';
	private static $workoutTypeId = 'workoutTypeId';
	private static $date = 'date',
	private static $distance = 'distance';
	private static $time = 'time';
	private static $comment ='comment';
	
	/*
		//Funktion för att hämta alla namn ur databasen.
	public function getAll(){
		try{
			$db = $this->connection();
			$sql = "SELECT * FROM $this->dbTable";
			$query = $db->prepare($sql);
			$query->execute();

			foreach ($query->fetchAll() as $user) {
				$userId = $user['userId'];
				$username = $user['username'];
				$password = $user['password'];
				$time = $user['time'];
				$this->userList[] = new \Model\User($userId, $username, $password, $time);
			}
			return $this->userList;	
		}
		catch(\PDOException $e){
			throw new Exception('Fel uppstod i samband med hämtning av namn från databasen.');
		}
	}
	*/
}