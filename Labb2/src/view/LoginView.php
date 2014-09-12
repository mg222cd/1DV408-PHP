<?php
namespace view;

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
		"<form action='' method='get'>
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
		if (isset($_GET[$this->getKey_loginButton]) === TRUE) {
			return TRUE;
		} else {
			return FALSE;
		}
	}

	//Funktion som visar sida när man är inloggad.
	public function loggedInPage(){
		return
		"<form>
		<fieldset>
		<legend><h2>Du är inloggad</h2></legend>
		<input type='submit' name='logoutButton' value='Logga ut' />	
		</fieldset>
		</form>
		";
	}

	//Funktion som kollar om användaren tryckt på Logga ut-knappen
	public function triedToLogout(){

	}
}