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

	//Funktion för utloggning
	public function doLogout(){
		$_SESSION['LoggedIn'] = "no";
	}
}