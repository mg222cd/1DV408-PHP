<?php

class User{
	private $userId;
	private $username;
	private $password;

	public function __construct($userId = NULL, $username = NULL, $password = NULL){
		$this->userId = $userId;
		$this->username = $username;
		$this->password = $password;
	}

	public function getName(){
		return $this->username;
	}
}