<?php
namespace View;

class LoginView{
private $username;
private $password;
private $message;
private $register;
	
	/**
	* Login form to show on start page
	*
	* param string $html
	*/
	public function loginForm(){
		$html= "
		<div class='row'>
		<div class='col-xs-6'>
        <h3>Logga in</h3>
        <p>$this->message</p>
        <form method='post' role='form' action='?LoggedIn'>
        	<div class='form-group'>
        	<label for='username'>E-post</label>
            <input type='text' class='form-control' maxlength='255' name='username' id='username' value='$this->username'>
            </div>
            <div class='form-group'>
            <label for='password'>Lösenord</label>
			<input type='password' class='form-control' maxlength='255' id='password' name='password'>
            </div>
            <div class='checkbox'>
            <label>
            <input type='checkbox' name='check'> Håll mig inloggad
            </label>
            </div>
            <input type='submit' value='Logga in' name='submit' class='btn btn-default'>
        </form>
        <div id='link'><a href='?Register'>Registrera ny användare</a></div>
        </div>
        <div class='col-xs-6'>
        <img src='./BasicStyles/DinSpring.png' class='img-responsive' alt='DinSpring logo'>
        </div>
        </div>";

        return $html;
	}	
}