<?php

class registerView{
	private $message;
	private $username;
	private $password;
	private $passwordRepeat;
	private $sendButton;

	public function registerForm(){
		$ret = "<h2>Laborationskod för mg222cd</h2>
		<div id='link'><a href='./'>Tillbaka</a></div>
        <h3>Ej inloggad, Registrerar användare</h3>
        <p>$this->message</p>
        <form method='post' action='?Register'>
            <p>Namn: <input type='text' name='username' value='$this->username'></p>
            <p>Lösenord: <input type='password' name='password'></p>
            <p>Repetera Lösenord: <input type='password' name='passwordRepeat'></p>
            <input type='submit' value='Skicka' name='sendButton'>
        </form>";
        return $ret;
	}

	public function confirmedRegister(){
		if (isset($_POST['sendButton'])) {
			return TRUE;
		} 
		else {
			return FALSE;
		}
		
	}

	public function getUsername(){
		if (isset($_POST['username'])) {
			$this->username = $_POST['username'];
			return $this->username;
		} 
		else {
			return FALSE;
		}
	}

	public function getPassword(){
		if (isset($_POST['password'])) {
			$this->username = $_POST['password'];
			return $this->password;
		} 
		else {
			return FALSE;
		}
	}



}