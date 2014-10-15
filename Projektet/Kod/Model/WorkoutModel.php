<?php
namespace Model;

class WorkoutModel{

	public function isShortDate($var){
		$regex = '/^[0-9]{4,4}\-[0-9]{2,2}\-[0-9]{2,2}$/ ';
		if (preg_match($regex, $var)) { 
			return TRUE;
		} 
		return FALSE; 
	}

	public function validateDistance($var){
		$regex = '/^[0-9]{1,4}$/';
		if (preg_match($regex, $var)) {
			return TRUE;
		}
		return FALSE;
	}
}