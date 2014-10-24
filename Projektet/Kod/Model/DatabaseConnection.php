<?php
namespace Model;

/**
* Class to handle Database connections in Repository
* 
*/
abstract class DatabaseConnection{
	
	protected $dbUsername = 'root'; 
	protected $dbPassword = 'root';
	protected $dbConnstring = 'mysql:host=mysql01.citynetwork.se;dbname=login;charset=utf8';
	protected $dbConnection;
	protected $dbTable;

	protected function connection(){
		if ($this->dbConnection == NULL) {
			$this->dbConnection = new \PDO($this->dbConnstring, $this->dbUsername, $this->dbPassword);
		}

		$this->dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		return $this->dbConnection;
	}
}