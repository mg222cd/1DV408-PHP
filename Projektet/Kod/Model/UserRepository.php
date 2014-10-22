<?php
namespace Model;

require_once ('./Model/DatabaseConnection.php');
require_once('./Model/User.php');

class UserRepository extends DatabaseConnection{
	private $userList = array();
	private $userId = 'userId';
	private $username = 'username';
	private $password = 'password';

	public function __construct(){
		$this->dbTable = 'member';
	}

	/**
	* Function to pickup and return all posts from Usertable
	* 
	* @return array $userlist
	*/
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
	}

	/**
	* Function to padd new user to Table after registration. Password is encrypted.
	* 
	* @param string $username, $password
	*/
	public function add($username, $password){
		try{
			$db = $this->connection();
			$sql = "INSERT INTO member (".$this->username.",".$this->password.") VALUES (?, ?)";
			$params = array($username, $password);

			$query = $db->prepare($sql);
			$query->execute($params);

			return TRUE;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då användare skulle tilläggas i databasen.');
		}
	}

	/**
	* Function to update user-row with timestamp of latest login
	* 
	* @param string $username, $timeToSet
	*/
	public function setTime($username, $timeToSet){
		try{
			$db = $this->connection();
			$sql = "UPDATE member SET time=? WHERE username=?";
			$params = array($timeToSet, $username);

			$query = $db->prepare($sql);
			$query->execute($params);

			return TRUE;
		}
		catch(\PDOException $e){
			throw new \Exception('Fel uppstod då tid på användare skulle tilläggas i databasen.');
		}
	}
}