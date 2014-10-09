<?php
namespace View;

class LoggedInView{
    private $signOut = "SignOut";
    private $message;

    public function userPressedLogOut(){
        if(isset($_GET[$this->signOut])){
            return true;
        }
        else{
            return false;
        }
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function logOutSuccessMessage(){
        return $this->message = "Du har nu loggat ut";
    }

    public function LoggedInView(){
        $ret = "<h2>Laborationskod för mg222cd</h2>

        <h3>Admin är inloggad</h3>

        <p>$this->message</p>

        <a href='?$this->signOut'>Logga ut</a>";

        return $ret;
    }
}