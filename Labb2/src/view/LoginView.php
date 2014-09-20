<?php
namespace view;

use DateTime;
class LoginView{

	//variabler för informationslagring
	private $getKey_name = "name";
	private $getKey_password = "password";
	private $getKey_loginButton = "loginButton";
	private $getKey_logoutButton = "logoutButton";
	private $getKey_rememberMeBox = "rememberMeBox";
	
	//Funktion som visar inloggningsruta
	public function doLoginPage(){
		$name = isset($_POST['name']) ? $_POST['name'] : '';
		return 
		"<div id='link'><a href='#'>Registrera ny användare</a></div>
		<form action='' method='post'>
		<fieldset>
		<legend>Login - skriv in användarnamn och lösenord</legend>
		Namn:<input type='text' name='name' value='$name' />
		Lösenord:<input type='password' name='password' />
		Håll mig inloggad<input type='checkbox' name='rememberMeBox' />
		<input type='submit' name='loginButton' value='Logga in' />
		</fieldset>
		</form>";
	}

	//Funktion som kollar om användaren tryckt på Logga in-knappen
	public function triedToLogin(){
		if (isset($_POST['loginButton']) == TRUE) {
			return TRUE;
		} 
		else {
			return FALSE;
		}
	}

	//Funktion som visar sida när man är inloggad.
	public function loggedInPage(){
		return
		"<form action='' method='post'>
		<legend></legend>
		<input type='submit' name='logoutButton' value='Logga ut' />	
		</form>
		";
	}

	//Funktion som kollar om användaren tryckt på Logga ut-knappen
	public function triedToLogout(){
		if (isset($_POST['logoutButton']) == TRUE) {
			return TRUE;
		} 
		else {
			return FALSE;
		}	
	}

	//Funktion som returnerar aktuellt datum och tid
	public function getDateAndTime(){
		setlocale( 'sv_SE.UTF-8', 'Swedish');
		$date = date('d F');
		$year = date('Y');
		$day = ucfirst(strftime("%A"));
		$day = utf8_encode($day);
		$time = date('H:i:s');
		return $day . ', den ' . $date . ' år ' . $year . '. Klockan är [' . $time . ']';
	}

	//Funktion för att hämta angivet användarnamn
	public function getName(){
		if (isset($_POST['name']) != NULL) {
			return $_POST['name'];
		}
		return NULL;
	}

	//Funkrion för att hämta angivet lösenord
	public function getPassword(){
		if (isset($_POST['password']) != NULL) {
			return $_POST['password'];
		}
		return NULL;
	}

	//Funktion för att kontrollera "Håll mig inloggad"-checkboxen
	public function checkBox(){
		if (isset($_POST[$this->getKey_rememberMeBox]) != NULL) {
			return TRUE;
		} 
		else {
			return FALSE;
		}
	}



}