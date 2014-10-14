<?php
namespace Model;

require_once("./Model/Workouttype.php");

class WorkouttypeRepository extends DatabaseConnection{
	private $workouttypeList = array();
	private static $workoutTypeId = 'workoutTypeId';
	private static $name = 'name';

	public function __construct(){
		$this->dbTable = 'workouttype';
	}

	/*
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
			throw new \Exception('Fel uppstod i samband med hämtning av namn från databasen.');
		}
	}*/

	public function getAll(){
		try {
			$db = $this->connection();
			$sql = "SELECT * FROM $this->dbTable";
			$query = $db->prepare($sql);
			$query->execute();
		foreach ($query->fetchAll() as $type) {
			$workoutTypeId = $type['workoutTypeId'];
			$name = $type['name'];
			$this->workouttypeList[] = new \Model\Workouttype($workoutTypeId, $name);
		}
		return $this->workouttypeList;
			
		} 
		catch (\PDOException $e) {
			throw new \Exception("Fel uppstod i samband med hämtning av träningstyper från databasen.");
			
		}
	}
}