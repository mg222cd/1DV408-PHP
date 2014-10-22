<?php
namespace Model;

require_once('./Model/UserRepository.php');

class UserModel{
    //instances
    private $userRepo;
    private $username;
    //validation
    private $authenticatedUser = false;
    //rules
    private $minValueUsername = 6;
    private $minValuePassword = 6;

    public function __construct(){
        $this->userRepo = new \Model\UserRepository();
    }

    //RULES
    public function getMinLengthUsername(){
        return $this->minValueUsername;
    }
    //RULES
    public function getMinLengthPassword(){
        return $this->minValuePassword;
    }
    //RULES
    public function encryptPassword($password){
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $encryptedPassword;
    }

    //RULES
    public function stripTags($username){
        $strippedUsername = strip_tags($username);
        if ($strippedUsername != $username) {
            return $strippedUsername;
        }
        else{
            return NULL;
        }
    }

    //VALIDATION
    public function validateUsername($username){
        if (strlen($username) >= $this->minValueUsername) {
            return TRUE;
        } 
        else {
            return FALSE;
        }   
    }
    //VALIDATION
    public function validatePassword($password){
        if (strlen($password) >= $this->minValuePassword) {
            return TRUE;
        } 
        else {
            return FALSE;
        }  
    }
    //VALIDATION
    public function validateEmail($emailToValidate){
        return filter_var($emailToValidate, FILTER_VALIDATE_EMAIL);
    }
    //VALIDATION
    //Control if login with SESSION is valid
    public function getAuthenticatedUser($userAgent){
        if(isset($_SESSION["UserAgent"]) && $_SESSION["UserAgent"] === $userAgent){
            if(isset($_SESSION["ValidLogin"])){
                $this->authenticatedUser = true;
            }
        }
        return $this->authenticatedUser;
    }
    
    //DATABASE-CALL
    //Get UserId from username
    public function getUserId($username){
        $existingUsers = $this->userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            if ($name == $username) {
                return $existingUser->getUserId();
            }
        }
    }
    //DATABASE-CALL
    //Secure Username is avaliable
    public function nameAlreadyExists($nameToCheck){
        $existingUsers = $this->userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            if ($name == $nameToCheck) {
                return TRUE;
            }
        }
    }//Facade function
    public function userExists($username){
        return $this->nameAlreadyExists($username);
    }
    //DATABASE-CALL
    //Get latest timestamp from username
    private function getCookieTime($username){
        $existingUsers = $this->userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            if ($name == $username) {
                return $existingUser->getTime();
            }
        }
    }
    //DATABASE-CALL
    //Set latest timestamp from username
    public function setTime($time){
        return $this->userRepo->setTime($this->username, $time);
    }
    //DATABASE-CALL
    //Control if the login-inputs are valid
    public function validateLogin($usernameToCheck, $passwordToCheck, $userAgent){
        //Sets authenticatedUser as true or false depending on if data match database or not
        $existingUsers = $this->userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            $password = $existingUser->getPassword();
            if ($name == $usernameToCheck && password_verify($passwordToCheck, $password)) {
                $this->username = $name;
                $this->authenticatedUser = TRUE;
            }
        }
        if($this->authenticatedUser){
            $_SESSION["ValidLogin"] = $usernameToCheck;
            $_SESSION["UserAgent"] = $userAgent;
        }
        return $this->authenticatedUser;
    }
    //DATABASE-CALL
    //Validate if login with cookie really is valid (checks timestamp)
    public function controlCookieValue($cookieValue, $userAgent){
        if($this->userExists($cookieValue)){
            $time = $this->getCookieTime($cookieValue);
            if($time > time()){
                $_SESSION["ValidLogin"] = $cookieValue;
                $_SESSION["UserAgent"] = $userAgent;
                return $this->authenticatedUser = true;
            }
            else{
                $this->logout();
                return $this->authenticatedUser = false;
            }
        }
    }

    //Function for setting and getting Username from SESSION
    //(session is set for all scenarios, incl. cookies)
    public function setAndGetUsername(){
        $this->username = $_SESSION["ValidLogin"];
        return $this->username;
    }


    //Logout task, unset session
    public function logout(){
        if(isset($_SESSION["ValidLogin"])){
            unset($_SESSION["ValidLogin"]);
        }
        return $this->authenticatedUser = false;
    }
}