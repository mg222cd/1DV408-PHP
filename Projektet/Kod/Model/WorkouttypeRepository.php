<?php
namespace Model;

require_once("./Model/Workouttype.php");

class WorkouttypeRepository extends DatabaseConnection{
	private $workouttypeList = array();
	private $workoutTypeId = 'workoutTypeId';
	private $name = 'name';

	public function __construct(){
		$this->dbTable = 'workouttype';
	}

	/**
	* Function to get all workouttypes with id and name
	*
	* @return array $workouttypeList (workouttype object)
	*/
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