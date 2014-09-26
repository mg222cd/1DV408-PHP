<?php

class LoginView{
    private $username;
    private $password;
    private $message;
    private $register;

    public function ViewLogin(){
        $ret = "<h2>Laborationskod för mg22cd</h2>
        <h3>Ej inloggad</h3>
        <p>$this->message</p>
        <div id='link'><a href='#'>Registrera ny användare</a></div>
        <form method='post' action='?LoggedIn'>
            Användarnamn: <input type='text' name='username' value='$this->username'>
            Lösenord: <input type='password' name='password'>
            Håll mig inloggad <input type='checkbox' name='check'>
            <input type='submit' value='Logga in' name='submit'>
        </form>";

        return $ret;
    }

    public function getInformation(){
        if(isset($_POST['username'])){
            $this->username = $_POST['username'];
        }
        if(isset($_POST['password'])){
            $this->password = $_POST['password'];
        }
    }

    public function getSubmit(){
        if(isset($_POST['submit'])){
            return true;
        }
        else{
            return false;
        }
    }

    public function getUsername(){
        return $this->username;
    }

    public function getPassword(){
        return $this->password;
    }

    public function failedLogIn($username, $password){
        if($username === ""){
            $this->message = "Användarnamn saknas";
        }
        else if($password === ""){
            $this->message = "Lösenord saknas";
        }
        else{
            $this->message = "Felaktigt användarnamn och/eller lösenord";
        }
    }

    public function LogInSuccessMessage(){
        return $this->message = "Inloggning lyckades";
    }

    public function setMessage($message){
        $this->message = $message;
    }

    public function wantCookie(){
        if(isset($_POST['check'])){
            return true;
        }
        else{
            return false;
        }
    }
}