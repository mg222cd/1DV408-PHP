<?php
require_once ('./Model/DatabaseConnection.php');
require_once('./Model/User.php');

class UserRepository extends DatabaseConnection{
	private $userList = array();
	private static $userId = 'userId';
	private static $username = 'username';
	private static $password = 'password';

	public function __construct(){
		$this->dbTable = 'member';
	}

	public function query($sql, $params = NULL) {
		try {
			$db = $this -> connection();

			$query = $db -> prepare($sql);
			$result;
			if ($params != NULL) {
				if (!is_array($params)) {
					$params = array($params);
				}

				$result = $query -> execute($params);
			} else {
				$result = $query -> execute();
			}

			if ($result) {
				return $result -> fetchAll();
			}

			return NULL;
		} catch (\PDOException $e) {
			throw new Exception('Fel uppstod i samband anslutning till databasen.');
		}
	}

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

				$this->userList[] = new User($userId, $username, $password);
			}
			return $this->userList;	
		}
		catch(\PDOException $e){
			throw new Exception('Fel uppstod i samband med hämtning av namn från databasen.');
		}
	}

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
			throw new Exception('Fel uppstod då användare skulle tilläggas i databasen.');
		}
	}
}