<?php
namespace Helpers;

/**
* Class to handle messages to be shown after redirects from header location (used to show Succeed-messages after CRUD-funktions in Workout-table)
* Got help with this class from David Söderberg
*
* @return string $message
*/
class Message{
	private $message = "message";

	public function setMessage($value){
		$_SESSION[$this->message] = $value;
	}

	public function getMessage(){
		if (isset($_SESSION[$this->message])) {
			$message = $_SESSION[$this->message];
		}
		else {
			$message = "";
		}
		unset($_SESSION[$this->message]);

		return $message;
	}	

}