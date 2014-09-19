<?php
namespace model;

require_once("src/view/LoginView.php");
require_once("src/controller/LoginController.php");

class LoginModel{

	//Funktion för att kolla om användaren är inloggad
	public function isLoggedIn(){
		if ($_SESSION['LoggedIn'] == "yes") {
			return TRUE;
		} 
		else {
			return FALSE;
		}
	}

	//Funktion för att kontrollera inloggningsuppgifter
	public function doLogin($name, $password){
		switch ($name) {
			//kontroll användarnamn
			case 'Admin':
				//kontroll lösenord
				if ($password == 'Password') {
					$_SESSION['LoggedIn'] = "yes";
					return TRUE;
				}
			break;
			//kontroll användarnamn
			case 'Marike':
				//kontroll lösenord
				if ($password == 'Grinde') {
					$_SESSION['LoggedIn'] = "yes";
					return TRUE;
				}
				break;
			default:
			return FALSE;
			break;
		}
	return FALSE;	
	}

	//Funktion för att spara användarinfo 
	public function saveToFile($encryptedUser){
		$file = fopen('logins.txt', 'a');
		fwrite($file, $encryptedUser . "\n");
	}

	//Funktion för att kontrollera Cookien vid automatisk inloggning
	public function cookieSecurityCheck($stringToVerify){
		$lines = @file("logins.txt");
		//om filen inte finns
		if ($lines === FALSE) {
			return FALSE;
		}
		else{
			foreach ($lines as $line) {
				$line = trim($line);
				if ($line === $stringToVerify) {
					return TRUE;
				}
			}
			return FALSE;
		}	
	}

	//Funktion för att radera rader i filen tillhörande utloggad användare
	public function removeClientIdentifier($name){
		rename("logins.txt", "logins_temp.txt");
		$rows = @file("logins_temp.txt");
		if ($rows === FALSE) {
			return null;
		} 
		else {
			foreach ($rows as $row) {
				$row = trim($row);
				if (!strpos($row, $name) == 0) {
					$this->saveToFile($row);
				}
			}
		}
	}

	//Funktion för utloggning
	public function doLogout(){
		$_SESSION['LoggedIn'] = "no";
	}
}