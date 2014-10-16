<?php
namespace Model;

require_once("./Model/DatabaseConnection.php");
require_once("./Model/Workout.php");

class WorkoutRepository extends DatabaseConnection{
	private $workoutList = array();
	private static $workoutId = 'workoutId';
	private static $userId = 'userId';
	private static $workoutTypeId = 'workoutTypeId';
	private static $wdate = 'wdate';
	private static $distance = 'distance';
	private static $wtime = 'wtime';
	private static $comment ='comment';
	private $workouttypeTable;
	
	public function __construct(){
		$this->dbTable = 'workout';
		$this->workouttypeTable = 'workouttype';
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
			$sql = "SELECT $this->dbTable.workoutId, $this->dbTable.userId, $this->dbTable.workoutTypeId, $this->dbTable.wdate, 
							$this->dbTable.distance, $this->dbTable.wtime, $this->dbTable.comment, $this->workouttypeTable.name 
					FROM $this->dbTable
					LEFT JOIN workoutType
					ON $this->dbTable.workoutTypeId = $this->workouttypeTable.workoutTypeId
					WHERE userId = :userId
					ORDER BY $this->dbTable.wdate DESC
					";
			
			//$sql = "SELECT * FROM $this->dbTable WHERE userId = :userId";
			$params = array(':userId' => $userId);

			$query = $db->prepare($sql);
			$query->execute($params);

			foreach ($query->fetchAll() as $workout) {
				$workoutId = $workout['workoutId'];
				$userId = $workout['userId'];
				$workoutTypeId = $workout['workoutTypeId'];
				$wdate = $workout['wdate'];
				$distance = $workout['distance'];
				$wtime = $workout['wtime'];
				$comment = $workout['comment'];
				$workoutTypeName = $workout['name'];
				$this->workoutList[] = new \Model\Workout($workoutId, $userId, $workoutTypeId, $wdate, $distance, $wtime, $comment, $workoutTypeName);
			}
			return $this->workoutList;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod i samband med hämtning av träningspass från databasen.');
		}
	}

	/*
	public function add($username, $password){
		try{
			$db = $this->connection();
			$sql = "INSERT INTO member (".self::$username.",". self::$password.") VALUES (?, ?)";
			$params = array($username, $password);

			$query = $db->prepare($sql);
			$query->execute($params);

			return TRUE;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då användare skulle tilläggas i databasen.');
		}
	}*/
	//$sql2 = 'INSERT INTO $this->dbTable (".self::$userId.", ".self::$workoutTypeId.", ".self::$wdate.", ".self::$distance.", 
			//		".self::$wtime.", ".self::$comment.") 
			//		VALUES ("1", "5", "2014-10-15", "33", "03:22:22", "marike grinde test hejhej")';
	//$sql = "INSERT INTO $this->dbTable (".self::$userId.", ".self::$workoutTypeId.", ".self::$wdate.", ".self::$distance.", ".self::$wtime.", ".self::$comment.")";


	public function addWorkout($userId, $workoutTypeId, $wdate, $distance, $wtime, $comment){
		try{
			$db = $this->connection();
			
			$sql = "INSERT INTO $this->dbTable (".self::$userId.",".self::$workoutTypeId.",".self::$wdate.",".self::$distance.",".self::$wtime.",".self::$comment.")
               VALUES (userId = :userId, workoutTypeId = :workoutTypeId, wdate = :wdate, distance = :distance wtime = :wtime, comment = :comment);";
			$params = array (':userId' => $userId, ':workoutTypeId' => $workoutTypeId, ':wdate' => $wdate, 
				':distance' => $distance, ':wtime' => $wtime, ':comment' => $comment);

			$query = $db->prepare($sql);
			$query->execute($params);

			return TRUE;
		}
		catch(\PDOException $e){
			var_dump($e);
			//throw new \Exception('Fel uppstod då träningspass skulle tilläggas i databasen.');
		}	
	}
}