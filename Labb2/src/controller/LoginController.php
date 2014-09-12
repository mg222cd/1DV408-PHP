<?php
namespace controller;

require_once("src/view/LoginView.php");
require_once("src/model/loginModel.php");

class LoginController {

	private $loginView;
	private $loginModel;

	public function __construct(){
		$this->loginView = new \view\LoginView();
		$this->loginModel = new \model\loginModel();
	}

	public function doControll(){
			//varaibler för loginscenarion
			$status = "";
			$body;
			$messages = "";

			//hantering loginscenarion
			//scenario - användaren är redan inloggad
			if (isset($_COOKIE['name']) && isset($_COOKIE['password'])) {
				# code...
				//logga in med användarnamn och lösenord.
				//Kolla även om användaren tryckt på "Logga ut"
			} 
			//scenario - användaren är inte inloggad
			else {
				$body = $this->loginView->doLoginPage();
				$body .= $this->loginView->getDateAndTime();

				//scenario - användaren har tryck på "Logga in"
				if ($this->loginView->triedToLogin() === TRUE) {
					//kontroll av inloggningsuppgifter
					/////
					$body = $this->loginView->loggedInPage();
				} else {
					# code...
				}
				
			}
			
			return $body;
	}
}