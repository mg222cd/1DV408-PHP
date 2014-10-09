<?php
namespace View;

class RegisterView{
	private $message;
	private $username;
	private $password;
	private $passwordRepeat;
	private $sendButton;

	public function registerForm(){
		$username = isset($_POST['username']) ? $_POST['username'] : '';
        $html = "
        <div class='row'>
		<div class='col-xs-12 col-sm-6'> 
		<div id='link'><a href='./'>Tillbaka</a></div>
        <h3>Registrera ny användare</h3>
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
            <div class='form-group'>
            <label for='passwordRepeat'>Repetera lösenord</label>
			<input type='password' class='form-control' maxlength='255' id='passwordRepeat' name='passwordRepeat'>
            </div>
            <input type='submit' value='Registrera' name='sendButton' class='btn btn-default'>
            </div>
        </form>
        <div class='col-xs-12 col-sm-6'>
        <img src='./BasicStyles/DinSpring2.png' class='img-responsive image_startpage' alt='DinSpring alternativ logo'>
        </div>
        </div>";
        return $html;
	}

	public function setWrongUsername($number){
		$this->message = "<p>Användarnmanet har för få tecken. Minst " . $number . " tecken.</p>";
	}

	public function setWrongPassword($number){
		$this->message .= "<p>Lösenordet har för få tecken. Minst " . $number . " tecken.</p>";
	}

	public function setPasswordMismatch(){
		$this->message = "<p>Lösenorden matchar inte.</p>";
	}

	public function setUsernameAlreadyExists(){
		$this->message = "<p>Användarnamnet är redan upptaget.</p>";
	}

	public function setInvalidUsername($strippedUsername){
		$_POST['username'] = $strippedUsername;
		$this->message = "<p>Användarnamnet innehåller ogiltiga tecken.</p>";
	}

	public function confirmedRegister(){
		if (isset($_POST['sendButton'])) {
			return TRUE;
		} 
		else {
			return FALSE;
		}	
	}

	public function getUsername(){
		if (isset($_POST['username'])) {
			$this->username = $_POST['username'];
			return $this->username;
		} 
		else {
			return "";
		}
	}

	public function getPassword(){
		if (isset($_POST['password'])) {
			$this->password = $_POST['password'];
			return $this->password;
		} 
		else {
			return "";
		}
	}

	public function getPasswordRepeat(){
		if (isset($_POST['passwordRepeat'])) {
			$this->passwordRepeat = $_POST['passwordRepeat'];
			return $this->passwordRepeat;
		} 
		else {
			return "";
		}
	}



}