<?php
namespace View;

class CookieStorage{
    private $cookieName = "CookieStorage";
    private $message;
    private $cookieTime;

    public function save($username){
        $this->cookieTime = time()+3600;
        setcookie($this->cookieName, $username, $this->cookieTime);
        return $this->cookieTime;
    }

    //Tar bort kakan när man loggar ut eller när tiden har gått ut.
    public function deleteCookie(){
        setcookie($this->cookieName, "", time() - 3600);
    }

    //Tittar om kakan finns.
    public function loadCookie(){
        if(isset($_COOKIE[$this->cookieName])){
            return true;
        }
    }

    //Tittar om kakan redan existerar och i sådana fall så returnerar vi kakans värde.
    public function cookieExist(){
        if(isset($_COOKIE[$this->cookieName])){
            return $_COOKIE[$this->cookieName];
        }
    }

    //Meddelanden
    public function cookieSaveMessage(){
        return $this->message = "Inloggning lyckades och vi kommer att komma ihåg dig nästa gång";
    }

    public function cookieLoadMessage(){
        return $this->message = "Inloggning lyckades via cookies";
    }

    public function cookieModifiedMessage(){
        return $this->message = "Felaktig information i cookie";
    }
}