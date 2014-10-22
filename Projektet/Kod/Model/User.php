<?php
namespace Model;

class User{
	//columns in table User
	private $userId;
	private $username;
	private $password;
	private $time;

	//setters 
	public function __construct($userId, $username, $password, $time){
		$this->userId = $userId;
		$this->username = $username;
		$this->password = $password;
		$this->time = $time;
	}

	//getters
	public function getUserId(){
		return $this->userId;
	}

	public function getName(){
		return $this->username;
	}

	public function getPassword(){
		return $this->password;
	}

	public function setTime($time){
		$this->time = $time;
	}

	public function getTime(){
		return $this->time;
	}
}