<?php
namespace View;

class LoggedInView{
    private $signOut = "signOut";
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
        $ret = "

        <h3>Inloggad</h3>

        <p>$this->message</p>

        <a href='?$this->signOut'>Logga ut</a>";

        return $ret;
    }
}