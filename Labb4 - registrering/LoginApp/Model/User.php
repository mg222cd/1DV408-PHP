<?php

class UserNew{
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