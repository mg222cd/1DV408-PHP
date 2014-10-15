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

	public function validateTime($hours, $minutes, $seconds){
		$regex = '/^[0-9]{1,2}$/';
		if (preg_match($regex, $hours) && preg_match($regex, $minutes) && preg_match($regex, $seconds)) {
			return TRUE;
		}
		return FALSE;
	}

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