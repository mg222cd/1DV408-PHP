<?php
namespace view;

class LoginView{
	
	//Funktion som visar inloggningsruta
	public function DoLoginPage(){
		return 
		"<form action='' method='get'>
		<fieldset>
		<legend>Login - skriv in användarnamn och lösenord</legend>
		Namn:<input type='text' name='name' />
		Lösenord:<input type='text' name='password' />
		<input type='submit' name='login' value='Logga in' />
		</fieldset>
		</form>";
	}
}