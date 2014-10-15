<?php
namespace Model;

require_once('./Model/UserRepository.php');

class UserModel{
    private $userRepo;
    private $username;
    private $authenticatedUser = false;
    private $minValueUsername = 6;
    private $minValuePassword = 6;

    public function __construct(){
        $this->userRepo = new \Model\UserRepository();
    }

    public function getMinLengthUsername(){
        return $this->minValueUsername;
    }

    public function getMinLengthPassword(){
        return $this->minValuePassword;
    }

    public function setAndGetUsername(){
        $this->username = $_SESSION["ValidLogin"];
        return $this->username;
    }

    public function getUserId($username){
        $existingUsers = $this->userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            if ($name == $username) {
                return $existingUser->getUserId();
            }
        }
    }

    //Kontrollerar längden på Username
    public function validateUsername($username){
        if (strlen($username) >= $this->minValueUsername) {
            return TRUE;
        } 
        else {
            return FALSE;
        }   
    }

    //Kontrollerar längden på Password
    public function validatePassword($password){
        if (strlen($password) >= $this->minValuePassword) {
            return TRUE;
        } 
        else {
            return FALSE;
        }  
    }

    public function validateEmail($emailToValidate){
        return filter_var($emailToValidate, FILTER_VALIDATE_EMAIL);
    }

    //Funktion för att kryptera password
    public function encryptPassword($password){
        $encryptedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $encryptedPassword;
    }

    //Funktion för att filtrera bort ogiltiga tecken.
    public function stripTags($username){
        $strippedUsername = strip_tags($username);
        if ($strippedUsername != $username) {
            return $strippedUsername;
        }
        else{
            return NULL;
        }
    }

    //Kontrollerar om namnet redan finns
    public function nameAlreadyExists($nameToCheck){
        $existingUsers = $this->userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            if ($name == $nameToCheck) {
                return TRUE;
            }
        }
    }

    //Fasadfunktion 
    public function userExists($username){
        return $this->nameAlreadyExists($username);
    }

    private function getCookieTime($username){
        $existingUsers = $this->userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            if ($name == $username) {
                return $existingUser->getTime();
            }
        }
    }

    public function setTime($time){
        return $this->userRepo->setTime($this->username, $time);
    }

    public function validateLogin($usernameToCheck, $passwordToCheck, $userAgent){
        //Sätt authenticatedUser till true eller false beroende på om uppgifterna stämmer med dem i DB
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

    //Tittar om användaren är inloggad redan med sessions eller inte.
    public function getAuthenticatedUser($userAgent){
        if(isset($_SESSION["UserAgent"]) && $_SESSION["UserAgent"] === $userAgent){
            if(isset($_SESSION["ValidLogin"])){
                $this->authenticatedUser = true;
            }
        }
        return $this->authenticatedUser;
    }

    //Om användaren väljer att logga ut så tas sessionen bort.
    public function logout(){
        if(isset($_SESSION["ValidLogin"])){
            unset($_SESSION["ValidLogin"]);
        }
        return $this->authenticatedUser = false;
    }

    //Kontrollerar om kakans värde stämmer överens
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


    /*
    * DÖD KOD - TA BORT NEDAN:
    *
    //Sparar tiden när kakan skapades i en fil.
    public function saveCookieTime($time){
        file_put_contents("exist.txt", $time);
    }
    */


}