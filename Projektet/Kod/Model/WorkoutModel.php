<?php
namespace Model;

class WorkoutModel{

	//Validator för date-field
	//Accepted format "YYYY-MM-DD"
	public function isShortDate($var){
		$regex = '/^[0-9]{4,4}\-[0-9]{2,2}\-[0-9]{2,2}$/ ';
		if (preg_match($regex, $var)) { 
			return TRUE;
		} 
		return FALSE; 
	}

	public function validateDate($dateToValidate){
		if (strtotime($dateToValidate) < strtotime(date('Y-m-d'))) {
			return $dateToValidate;
		}
		return date('Y-m-d');
	}

	//Validator for distance-field
	//Accepted format, 1-4 numbers
	public function validateDistance($var){
		$regex = '/^[0-9]{1,4}$/';
		if (preg_match($regex, $var)) {
			return TRUE;
		}
		return FALSE;
	}

	//Validator for time-fields
	//Accepted format, 1-2 numbers
	public function validateTime($hours, $minutes, $seconds){
		$regex = '/^[0-9]{1,2}$/';
		if (preg_match($regex, $hours) && preg_match($regex, $minutes) && preg_match($regex, $seconds)) {
			return TRUE;
		}
		return FALSE;
	}

	//Validator för comment-fiels
	//Filtrates oyt html and tags
	public function sanitizeText($comment){
        $strippedComment = strip_tags($comment);
        if ($strippedComment != $comment) {
            return $strippedComment;
        }
        else{
            return NULL;
        }
    }
}