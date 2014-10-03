<?php

abstract class DatabaseConnection{
	protected $dbUsername = '101368-fs50541';
	protected $dbPassword = 'Katt1234%';
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