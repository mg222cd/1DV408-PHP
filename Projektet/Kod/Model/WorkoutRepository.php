<?php
namespace Model;

require_once("./Model/DatabaseConnection.php");
require_once("./Model/Workout.php");

class WorkoutRepository extends DatabaseConnection{
	private $workoutList = array();
	private $workoutId = 'workoutId';
	private $userId = 'userId';
	private $workoutTypeId = 'workoutTypeId';
	private $wdate = 'wdate';
	private $distance = 'distance';
	private $wtime = 'wtime';
	private $comment ='comment';
	private $workouttypeTable;
	
	public function __construct(){
		$this->dbTable = 'workout';
		$this->workouttypeTable = 'workouttype';
	}

	/**
	* Pickup all workouts to a specific user
	*
	* @param int $userId
	* @return Workout $WorkoutList (workout object)
	*/
	public function getAllWorkouts($userId){
		try{
			$db = $this->connection();
			$sql = "SELECT $this->dbTable.workoutId, $this->dbTable.userId, $this->dbTable.workoutTypeId, $this->dbTable.wdate, 
							$this->dbTable.distance, $this->dbTable.wtime, $this->dbTable.comment, $this->workouttypeTable.name 
					FROM $this->dbTable
					LEFT JOIN workouttype
					ON $this->dbTable.workoutTypeId = $this->workouttypeTable.workoutTypeId
					WHERE userId = :userId
					ORDER BY $this->dbTable.wdate DESC
					";
			
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

	/**
	* Add workout to database.
	*
	* @param string $userId, string $workoutTypeId, string $wdate, string $distance, string $wtime, string $comment
	* @return bool
	*/
	public function addWorkout($userId, $workoutTypeId, $wdate, $distance, $wtime, $comment){
		var_dump($wtime);
		try{
			$db = $this->connection();
			
			$sql = "INSERT INTO $this->dbTable (".$this->userId.",".$this->workoutTypeId.",".$this->wdate.",".$this->distance.",".$this->wtime.",".$this->comment.")
               VALUES (?, ?, ?, ?, ?, ?);";
			$params = array ($userId, $workoutTypeId, $wdate, $distance, $wtime, $comment);

			$query = $db->prepare($sql);
			$query->execute($params);

			return TRUE;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då träningspass skulle tilläggas i databasen.');
		}	
	}

	/**
	* Delete one workout from database.
	*
	* @param int $workoutId, $userId
	* @return bool
	*/
	public function deleteWorkout($workoutId, $userId){
		try{
			$db = $this->connection();
			
			$sql = "DELETE FROM $this->dbTable WHERE workoutId=? AND userid=?";
			$params = array ($workoutId, $userId);

			$query = $db->prepare($sql);
			$query->execute($params);

			return $query->rowCount() > 0;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då träningspass skulle tas bort ur databasen.');
		}	
	}

	/**
	* Select-function that validates userId has rights to view/change selected workoutId
	*
	* @param int $workoutId, $userId
	* @return array $workoutList (workout object)
	*/
	public function certificatedToUpdate($workoutId, $userId){
		try{
			$db = $this->connection();
			
			$sql = "SELECT * FROM $this->dbTable 
					LEFT JOIN workouttype
					ON $this->dbTable.workoutTypeId = $this->workouttypeTable.workoutTypeId
					WHERE workoutID=? AND userId=?";
			$params = array ($workoutId, $userId);

			$query = $db->prepare($sql);
			$query->execute($params);

			foreach ($query->fetchAll() as $workout) {
				if ($workout['workoutId'] == $workoutId && $workout['userId'] == $userId) {
					$workoutId = $workout['workoutId'];
					$userId = $workout['userId'];
					$workoutTypeId = $workout['workoutTypeId'];
					$wdate = $workout['wdate'];
					$distance = $workout['distance'];
					$wtime = $workout['wtime'];
					$comment = $workout['comment'];
					$workoutTypeName = $workout['name'];
					$this->workoutList[] = new \Model\Workout($workoutId, $userId, $workoutTypeId, $wdate, $distance, $wtime, $comment, $workoutTypeName);
					return $this->workoutList;
				}
			}
			return FALSE;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då träningspass skulle tas bort ur databasen.');
		}	
	}

	/**
	* Function for updating a specific workout-row.
	*
	* @param string $workoutId, string $userId, string $workoutTypeId, string $wdate, string $distance, string $wtime, string $comment
	* @return bool
	*/
	public function updateWorkout($workoutId, $userId, $workoutTypeId, $wdate, $distance, $wtime, $comment){
		try{
			$db = $this->connection();
			$sql = "UPDATE $this->dbTable 
					SET workoutTypeId=?, wdate=?, distance=?, wtime=?, comment=? 
					WHERE workoutID=? AND userId=?";
			$params = array($workoutTypeId, $wdate, $distance, $wtime, $comment, $workoutId, $userId);

			$query = $db->prepare($sql);
			$query->execute($params);

			return TRUE;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då träningspass skulle uppdateras i databasen.');
		}	
	}
}