<?php
namespace Helpers;

//Fått hjälp med nedanstående av David Söderberg
class Message{
	private $message = "message";

	public function setMessage($value){
		$_SESSION[$this->message] = $value;
	}

	public function getMessage(){
		if (isset($_SESSION[$this->message])) {
			$message = $_SESSION[$this->message];
		}else {
			$message = "";
		}
		unset($_SESSION[$this->message]);

		return $message;
	}	

}