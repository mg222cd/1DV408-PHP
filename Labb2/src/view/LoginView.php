<?php
namespace view;

require_once("LoginCookieView.php");

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
		return 
		"<form action='' method='post'>
		<fieldset>
		<legend>Login - skriv in användarnamn och lösenord</legend>
		Namn:<input type='text' name='name' />
		Lösenord:<input type='text' name='password' />
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
		<fieldset>
		<legend><h2>Du är inloggad</h2></legend>
		<input type='submit' name='logoutButton' value='Logga ut' />	
		</fieldset>
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
		setlocale(LC_ALL, 'sv_SE');
		$date = date('d F');
		$year = date('Y');
		$day = ucfirst(strftime("%A"));
		$time = date('H:i:s');
		return $day . ', den ' . $date . ' år ' . $year . '. Klockan är [' . $time . ']';
	}

	//Funktion för att hämta angivet användarnamn
	public function getName(){
		if (isset($_COOKIE['name'])) {
			return $_COOKIE['name'];
		}
		elseif (isset($_POST['name']) != NULL) {
			return $_POST['name'];
		}
		return NULL;
	}

	//Funkrion för att hämta angivet lösenord
	public function getPassword(){
		if (isset($_COOKIE['password'])) {
			return $_COOKIE['password'];
		}
		elseif (isset($_POST['password']) != NULL) {
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

	//Funktion för att sätta Cookies
	public function createCookie($name, $password){
		$_COOKIE['name'] = $name;
		setcookie('name', $name, time()+3600);
		$_COOKIE['password'] = $password;
		setcookie("password", $password, time()+3600);
	}

	//Funktion för att ta bort Cookies
	public function removeCookie($name, $password){
		if (isset($_COOKIE['name']) && isset($_COOKIE['password'])) {
			setcookie("name", "", time()-3600);
			setcookie("password", "", time()-3600);
		} 
		else {
			return NULL;
		}
	}

	//Funktion för att hämta name i Cookie
	public function getCookieName(){
		if (isset($_COOKIE['name'])) {
			return $_COOKIE['name'];
		} 
		else {
			return NULL;
		}
	}

	//Funktion för att hämta password i Cookie
	public function getCoookiePassword(){
		if (isset($_COOKIE['password'])) {
			return $_COOKIE['password'];
		} 
		else {
			return NULL;
		}
	}

}