<?php

class UserModel{
    private $username = 'Admin';
    private $password = 'Password';
    private $authenticatedUser = false;
    //Eftersom det bara finns 1 användare så har jag en sträng som jag placerar i kakan som jag jämför med men
    //den ändras inte utan den har ett satt värde.
    private $randomString = "dsdididjsadladacm";

    /**
     * @param $username
     * @param $password
     * @param $userAgent
     * @return bool
     * Tittar om användarnamn och lösenord från användaren stämmer överens.
     */
    public function validateLogin($username, $password, $userAgent){
        $this->authenticatedUser = ($this->username === $username && $this->password === $password);
        if($this->authenticatedUser){
            $_SESSION["ValidLogin"] = $this->username;
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