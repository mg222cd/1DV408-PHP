<?php
namespace View;

/**
* Class to handle Cookies, helper for LoginController
*
*/
class CookieStorage{
    private $cookieName = "CookieStorage";
    private $message;
    private $cookieTime;

    //Set cookie
    public function save($username){
        $this->cookieTime = time()+3600;
        setcookie($this->cookieName, $username, $this->cookieTime);
        return $this->cookieTime;
    }
    //Login with cookie
    public function loadCookie(){
        if(isset($_COOKIE[$this->cookieName])){
            return true;
        }
    }
    //If there is cookie set, return its value
    public function cookieExist(){
        if(isset($_COOKIE[$this->cookieName])){
            return $_COOKIE[$this->cookieName];
        }
    }
    //Logout task
    public function deleteCookie(){
        setcookie($this->cookieName, "", time() - 3600);
    }
    
}