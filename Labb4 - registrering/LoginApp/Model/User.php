<?php

class User{
	private $userId;
	private $username;
	private $password;

	public function __construct($userId, $username, $password){
		$this->userId = $userId;
		$this->username = $username;
		$this->password = $password;
	}

	public function getUserId(){
		return $this->userId;
	}

	public function getName(){
		return $this->username;
	}

	public function getPassword(){
		return $this->password;
	}

	//Funktion för att kontrollera att inskrivet namn ej redan finns
	public function nameControl($nameToControl){
		
	}
}