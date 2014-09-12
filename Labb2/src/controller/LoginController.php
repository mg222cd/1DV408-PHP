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
			$datetime;

			//hantering loginscenarion
			//scenario - användaren är redan inloggad
			if (isset($_COOKIE['name']) && isset($_COOKIE['password'])) {
				/*$this->loginModel->doLogin($this->loginView->getName(), $this->loginView->getPassword());
				if ($this->loginModel->isLoggedIn == TRUE) {
					$body = $this->loginView->loggedInPage();
				}
				else{
					$status = "Inloggningen misslyckades! Fel användarnamn eller lösenord, försök igen.";
				}*/
			} 
			//scenario - användaren är inte inloggad
			else {
				$body = $this->loginView->doLoginPage();
				$datetime = $this->loginView->getDateAndTime();

				//scenario - användaren har tryck på "Logga in"
				if ($this->loginView->triedToLogin() === TRUE) {
					//kontroll av inloggningsuppgifter
					if ($this->loginModel->doLogin($this->loginView->getName(), $this->loginView->getPassword())) {
						# code...
					}
					else{

					}
					$body = $this->loginView->loggedInPage();
				} else {
					# code...
				}
				
			}
			
			return $body . $datetime;
	}
}