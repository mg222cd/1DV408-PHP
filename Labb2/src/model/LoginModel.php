<?php
namespace model;

require_once("src/view/LoginView.php");
require_once("src/controller/LoginController.php");

class LoginModel{

	//Funktion för att kolla om användaren är inloggad
	public function isLoggedIn(){
		if (isset($_SESSION['LoggedIn']) && $_SESSION['LoggedIn'] == "yes") {
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
					$_SESSION['name'] = $name;
					return TRUE;
				}
			break;
			//kontroll användarnamn
			case 'Marike':
				//kontroll lösenord
				if ($password == 'Grinde') {
					$_SESSION['LoggedIn'] = "yes";
					$_SESSION['name'] = $name;
					return TRUE;
				}
				break;
			default:
			return FALSE;
			break;
		}
	return FALSE;	
	}

	public function getSessionName(){
		if (isset($_SESSION['name'])) {
			return $_SESSION['name'];
		} else {
			return "";
		}
		
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
		//rename("logins.txt", "logins_temp.txt");
		$rows = @file("logins.txt");
		if ($rows == FALSE) {
			return null;
		} 
		else {
			$content = "";
			foreach ($rows as $row) {
				$row = trim($row);
				//$checkRow = explode(",", $row);
				//$checkRow = $checkRow[0];
				if (!strpos($row, $name) == 0) {
					$content .= $row . "\n";
				}
			}
			$file = fopen('logins.txt', 'w+');
			fwrite($file, $content);
		}
	}

	//Funktion för utloggning
	public function doLogout(){
		unset($_SESSION['LoggedIn']);
		unset($_SESSION['name']);
		if (session_status () != PHP_SESSION_NONE) {
			session_destroy();
		}
		return "Du har nu loggat ut";
	}
}