<?php
namespace View;

class LoggedInView{
	
	/**
	* Login form to show on start page
	*
	* param string $html
	*/
	public function loginForm(){
		$html= "
        <h3>Ej inloggad</h3>
        <p>$this->message</p>
        <div id='link'><a href='?Register'>Registrera ny användare</a></div>
        <form method='post' action='?LoggedIn'>
            Användarnamn: <input type='text' name='username' value='$this->username'>
            Lösenord: <input type='password' name='password'>
            Håll mig inloggad <input type='checkbox' name='check'>
            <input type='submit' value='Logga in' name='submit'>
        </form>";

        return $html;
	}
}