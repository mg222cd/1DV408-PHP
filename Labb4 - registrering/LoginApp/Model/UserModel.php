<?php
require_once('./Model/UserRepository.php');

class UserModel{
    private $username = 'Admin';
    private $password = 'Password';
    private $authenticatedUser = false;
    //Eftersom det bara finns 1 användare så har jag en sträng som jag placerar i kakan som jag jämför med men
    //den ändras inte utan den har ett satt värde.
    private $randomString = "dsdididjsadladacm";
    //konstanter som håller reda på min.längd för username och password
    private $minValueUsername = 6;
    private $minValuePassword = 6;
    //const MIN_VALUE_USERNAME = 6;
    //const MIN_VALUE_PASSWORD = 6;

    //Funktioner för att hämta konstanter
    public function getMinLengthUsername(){
        return $this->minValueUsername;
    }

    public function getMinLengthPassword(){
        return $this->minValuePassword;
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

    /**
    * Makes sure E-mail address is valid format
    *
    * @param string $emailToValidate
    * @return bool
    */
    public function validateEmail($emailToValidate){
        return false;
        //return filter_var($emailToValidate, FILTER_VALIDATE_EMAIL);
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

    //Kontrollerar längden på Password
    public function validatePassword($password){
        if (strlen($password) >= $this->minValuePassword) {
            return TRUE;
        } 
        else {
            return FALSE;
        }  
    }

    //Kontrollerar om namnet redan finns
    public function nameAlreadyExists($nameToCheck){
        $userRepo = new UserRepository();
        $existingUsers = $userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            if ($name == $nameToCheck) {
                return TRUE;
            }
        }
    }


    /**
     * @param $username
     * @param $password
     * @param $userAgent
     * @return bool
     * Tittar om användarnamn och lösenord från användaren stämmer överens.
     */
    public function validateLogin($usernameToCheck, $passwordToCheck, $userAgent){
        //Sätt authenticatedUser till true eller false beroende på om uppgifterna stämmer med dem i DB
        $userRepo = new UserRepository();
        $existingUsers = $userRepo->getAll();
        foreach ($existingUsers as $existingUser) {
            $name = $existingUser->getName();
            $password = $existingUser->getPassword();
            if ($name == $usernameToCheck && password_verify($passwordToCheck, $password)) {
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

    public function __construct(){
        session_start();
    }

    //Om användaren väljer att logga ut så tas sessionen bort.
    public function LogOut(){
        if(isset($_SESSION["ValidLogin"])){
            unset($_SESSION["ValidLogin"]);
        }
        return $this->authenticatedUser = false;
    }

    //Hämtar ut strängen vars värde ska in i kakan.
    public function getRandomString(){
        return $this->randomString;
    }

    //Kontrollerar om kakans värde stämmer överens med randomsStrings värde.
    public function controlCookieValue($cookieValue, $userAgent){
        $time = file_get_contents("exist.txt");
        if($time > time()){
            if($this->randomString === $cookieValue){
                $_SESSION["ValidLogin"] = $this->username;
                $_SESSION["UserAgent"] = $userAgent;
                return $this->authenticatedUser = true;
            }
            else{
                return $this->authenticatedUser = false;
            }
        }
    }

    //Sparar tiden när kakan skapades i en fil.
    public function saveCookieTime($time){
        file_put_contents("exist.txt", $time);
    }


}