<?php
namespace view;

class LoginCookieView{

	//Funktion för att kryptera password
	public function encryptPassword($password){
		$encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
		return $encryptedPassword;
	}
	
	//Funktion för att sätta Cookies
	public function createCookie($name, $password){
		$_COOKIE['name'] = $name;
		setcookie('name', $name, time()+3600);
		$_COOKIE['password'] = $password;
		setcookie("password", $password, time()+3600);
		$timeStamp = time()+3600;
		$_COOKIE['timeStamp'] = $timeStamp;
		setcookie("timeStamp", $timeStamp, time()+3600);
	}

	//funktion för att hämta IP-adressen från vilken klienten ser på sidan
	public function getClientIdentifier(){
		return $_SERVER["REMOTE_ADDR"];
	}

	//Funktion för att göra unik sträng av Cookie-informationen
	public function pickupCookieInformation($encryptedPassword){
		$uniqueString = $encryptedPassword . $_COOKIE['timeStamp'] . $this->getClientIdentifier();
		return $_COOKIE['name'] . "," . md5($uniqueString);
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

	//Funktion för att ta bort Cookies
	public function removeCookie($name, $password){
		if (isset($_COOKIE['name']) && isset($_COOKIE['password'])) {
			setcookie("name", "", time()-3600);
			setcookie("password", "", time()-3600);
			setcookie("timeStamp", "", time()-3600);
		} 
		else {
			return NULL;
		}
	}
}