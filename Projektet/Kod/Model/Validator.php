<?php
namespace Model;

/**
 * class Validator used for validating purposes
 * 
 * @author Cem Cirman, Jacob Ottosson, Therese Andersson, Marike Grinde
 */
class Validator {

/**
* @return boolean TRUE if $var is a valid eMail address, FALSE otherwise */
	static function isEmail($var) {
		$pattern ="/^([a­zA­Z0­9])+([\.a­zA­Z0­9_­])*@([a­zA­Z0­9_­])+(\.[a­zA­Z0­9_­]+)+/";
		if(preg_match($pattern, $var)) { 
			return true;
		} 
		else {
			return false;
		} 
	}

	/**
	* @return boolean TRUE if $var is a valid Personal ID Number, FALSE otherwise *
	* Accepted formats are:
	* XXXXXX­XXXX
	* XXXXXXXXXX
	* XXXXXXXX­XXXX
	* XXXXXXXXXXXX */
	static function isPersonalIdNumber($var) {
		$pattern = “^(19|20)?([0­9]{6}[­]?[0­9]{4}$”; $stdForm = substr(str_replace(‘­’, ‘’, $var), ­10, 10);
		if (preg_match($pattern, $var) && Validator::isLuhn($stdForm)){ 
			return TRUE;
		} 
		else {
			return FALSE;
		} 
	}
	private static function isLuhn($ssn) {
		$sum = 0;
		for ($i = 0; $i < strlen($ssn)­1; $i++) {
			$tmp = substr($ssn, $i, 1) * (2 ­ ($i & 1)); if ($tmp > 9) $tmp ­= 9;
			$sum += $tmp;
		}
		$sum = (10 ­ ($sum % 10)) % 10;
		return substr($ssn, ­1, 1) == $sum; 
	}
	/**
	* @return boolean TRUE if $var is a valid Short Date address, FALSE otherwise *
	* Accepted formats are:
	* yyyy­mm­dd
	* yy­mm­dd
	* yymmdd 
	* yyyy-mm-dd
	*/
	static function isShortDate($var) {
		//yyyy­mm­dd
		$pattern1 = “^(19|20)\d\d[­ /.](0[1­9]|1[012])[­ /.](0[1­9]|[12]\d|3[01])$”;
		//yy­mm­dd
		$pattern2 = “^\d\d[­ /.](0[1­9]|1[012])[­ /.](0[1­9]|[12]\d|3[01])$”; //yymmdd
		$pattern3 = “^\d\d(0[1­9]|1[012])(0[1­9]|[12]\d|3[01])$”;
		if (preg_match($pattern1, $var) || preg_match($pattern2, $var) || preg_match($pattern3, $var) { 
			return TRUE;
		} else { 
			return FALSE; 
		} 
	}

	/**
	* @return boolean TRUE if $var is a valid Number, FALSE otherwise */
	static function isNumeric($var) {
		return is_numeric($var);
	￼}

	/**
	* @return boolean TRUE if $var is a valid Floating Number, FALSE otherwise */
	static function isFloat($var) {
		return is_float($var); 
	}

	/**
	* @return boolean TRUE if $var is a valid Integer Number, FALSE otherwise */
	static function isInteger($var) {
		return is_int($var); 
	}

	/**
	* @return boolean TRUE if $var is in given range, FALSE otherwise */
	static function isInRange($var, $min, $max) {
		if(!is_numeric($var) || $var < $min || $var > $max || !is_numeric($min) || !is_numeric($max)) { 
			return false;
		} 
		else {
			return true;
		} 
	}

	/**
	* @return boolean TRUE if $var is a valid String, FALSE otherwise */
	static function isString($var) {
	return is_string($var); 
	}

	/**
	* @return boolean TRUE if $var is a valid Password, FALSE otherwise */
	static function isPassword($var) {
		if(
			ctype_alnum($var) // letters & digits only
			&& strlen($var)>7 // at least 8 chars
			&& strlen($var)<17 // at most 16 chars
			&& preg_match('`[A­Z]`',$var) // at least one upper case
			&& preg_match('`[a­z]`',$var) // at least one lower case 
			&& preg_match('`[0­9]`',$var) // at least one digit
			){
			return true;
		} 
		else {
			return false;
		} 
	}

	/**
	* @param $text string
	* @param $flag boolean (default = false)
	* TRUE ­ allow HTML, dont allow JavaScript * FALSE ­ don't allow HTML nor JavaScript
	* @return string Sanitized string depending on the $flag
	*/
	static function sanitizeText($text, $flag = false) {
		//Code for not allowing HTML nor Javascript 
		if ($flag == false) {
			//Tar bort alla tags (javascript och html­tags)
			$result = filter_var($text, FILTER_SANITIZE_STRING); return $result;
		}
		//Code for allow HTML not JavaScript
		else {
			//Tar bort alla tags förutom dem vi allowar
			$result = strip_tags($text, ‘<p><a><img><b><i><h1><br> ‘); return $result;
		} 
	}


	/**
	* Test function for the validator class
	* @return boolean TRUE if the test succeeds, FALSE otherwise */
	/*
	static function Test(){
		//Test av isShortDate()
		if(isShortDate(87­02­15) && isShortDate(1987­02­14) && isShortDate(870214) {
			return TRUE; 
		}
		else {
			throw new Exception(“isShortDate() does not work.”);
			return FALSE; 
		}
		//Test av isNumeric() 
		if(isNumeric(‘hej’)) {
			throw new Exception(“isNumeric() does not work.”); 
			return FALSE;
		} 
		else {
			return TRUE; 
		}
		//Test av isInteger() 
		if(isInteger(‘hej’)) {
			throw new Exception(“isInteger() does not work.”); 
			return FALSE;
		} 
		else {
			return TRUE; 
		}
		//Test av isFloat() 
		if(isFloat(‘hej’)) {
			throw new Exception(“isFloat() does not work.”); 
			return FALSE;
		} 
		else {
			return TRUE; 
		}
		//Test av isEmail()
		if(isEmail(‘asddasfsdfsgdf’) || isEmail(‘11111111’) ) {
			throw new Exception(“isEmail() does not work.”); return FALSE;
		} 
		else {
			return TRUE; 
		}
		//Test av isInRange()
		if(isInRange(‘hej’, ‘på’, ‘dig’) || isInRange(20, 30, 10)) {
			throw new Exception(“isInRange() does not work.”); return FALSE;
		} 
		else {
			return TRUE; 
		}
		//Test av isPassword()
		if(isPassword(‘=?%¤#”#¤&%’) || isPassword(‘aaa’) || isPassword(‘111’) ||
			isPassword(‘aaa’) || isPassword(‘aaaaaaaaaaaaaaaaaa’) ||
			isPassword(‘1111111111111111111111111111111’) || isPassword(‘Jaaahhaa’) ) {
			throw new Exception(“isPassword() does not work.”); return FALSE;
		} 
		else {
			return TRUE; 
		}
	}
	*/
}
