<?php
namespace view;

class LoginCookieView{
	
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

	//Funktion som krypterar Cookiens lösenord och tidsstämpel
	public function encryptCookie(){
		$uniqueString = $_COOKIE['password']  .  $_COOKIE['timeStamp'];
		$encryptedString = $_COOKIE['name'] . md5($uniqueString);
		return $encryptedString;
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