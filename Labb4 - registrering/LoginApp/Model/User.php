<?php
require_once('./Model/UserList.php');

class User{
	private $userId;
	private $username;
	private $password;

	public function __construct($userId, $username, $password){
		$this->userId = $userId;
		$this->username = $username;
		$this->password = $password;
	}

	public function getName(){
		return $this->username;
	}
}