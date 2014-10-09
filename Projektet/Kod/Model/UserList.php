<?php
namespace Model;

require_once('./Model/User.php');

class UserList{
	private $userList;

	public function __construct(){
		$this->userList = array();
	}

	//funktion för att hämta lista med alla users
	public function getUsers(){
		return $this->userList;
	}

	//Funktion för att lägga till User
	public function addUser(User $user){
		if (!$this->contains($user)) {
			$this->userList[] = $user;
		}
	}

	//Funktion för att kontrollera att användaren inte redan finns
	public function contains(User $newUser){
		foreach ($this->userList as $key => $existingUser) {
			if ($newUser->getName() == $existingUser->getName()) {
				return TRUE;
			}
		}
		return FALSE;
	}

}