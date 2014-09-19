<?php
namespace controller;

require_once("src/view/LoginView.php");
require_once("src/model/LoginModel.php");
require_once("src/view/LoginCookieView.php");

class LoginController {

	private $loginView;
	private $loginCookieView;
	private $loginModel;

	public function __construct(){
		$this->loginView = new \view\LoginView();
		$this->loginCookieView = new \view\LoginCookieView();
		$this->loginModel = new \model\loginModel();
	}

	public function doControll(){
			//varaibler för loginscenarion
			$registerLink = "<a href='#''>Registrera ny användare</a> <br />";
			$status = "";
			$body;
			$messages = "";
			$datetime = $this->loginView->getDateAndTime();

			//hantering loginscenarion
			//scenario - användaren är redan inloggad
			if ($this->loginCookieView->getCookieName() != NULL && $this->loginCookieView->getCoookiePassword() != NULL) {
				//säkerhetskontroll 
				$stringToVerify = $this->loginCookieView->pickupCookieInformation($this->loginCookieView->getCoookiePassword());
				//jämför strängen mot dem i filen
				if ($this->loginModel->cookieSecurityCheck($stringToVerify) == TRUE) {
					$body = $this->loginView->loggedInPage();
					$status = "välkommen tillbaka!";
						if ($this->loginView->triedToLogout() == TRUE) {
							$this->loginModel->removeClientIdentifier($this->loginCookieView->getCookieName());
							$this->loginCookieView->removeCookie();
							$this->loginModel->doLogout();
							$status = "";
							$messages = "";
							$body = $this->loginView->doLoginPage();
						}
				} else {
					$body = $this->loginView->doLoginPage();
					$messages = "Fel uppstod i samband med inloggning via kaka. Vänligen logga in på nytt.";
				}
			}
			//scenario - användaren är inte inloggad
			else {
				$status = "<h2>Ej inloggad</h2>";
				$body = $this->loginView->doLoginPage();
				$datetime = $this->loginView->getDateAndTime();
				//scenario - användaren har tryck på "Logga in"
				if ($this->loginView->triedToLogin() === TRUE) {
					//kontroll av inloggningsuppgifter
					if ($this->loginModel->doLogin($this->loginView->getName(), $this->loginView->getPassword())) {
						//om användaren kryssat i "håll mig inloggad"
						if ($this->loginView->checkBox() == TRUE) {
							$encryptedPassword = $this->loginCookieView->encryptPassword($this->loginView->getPassword());
							$this->loginCookieView->createCookie($this->loginView->getName(), $encryptedPassword);
							$cookieUnique = $this->loginCookieView->pickupCookieInformation($encryptedPassword);
							$this->loginModel->saveToFile($cookieUnique);
							$status = "Inloggad";
							$messages = "Du är inloggad och vi kommer ihåg dig nästa gång";
							$body = $this->loginView->loggedInPage();
						}
						$this->loginModel->isLoggedIn();
						$status = "Inloggad";
					}
					else{
						if ($this->loginView->getName() == NULL) {
							$messages = "Användarnamn saknas";
						} 
						else if ($this->loginView->getPassword() == NULL) {
							$messages = "Lösenord saknas";
						}
						else {
							$messages = "Felaktigt användarnamn och/eller lösenord";
						}
						
					}
				} 
			}
			//scenario - användaren är nu inloggad
			if ($this->loginModel->isLoggedIn() == TRUE) {
				$body = $this->loginView->loggedInPage();
				//kontroll om användaren tryckt på logout
				if ($this->loginView->triedToLogout() == TRUE) {
					$this->loginModel->removeClientIdentifier($this->loginCookieView->getCookieName());
					$this->loginModel->doLogout();
					$this->loginView->removeCookie($this->loginView->getName(), $this->loginView->getPassword());
					$body = $this->loginView->doLoginPage();
				}
			}
			return $registerLink . $status . $messages . $body . $datetime;
	}
}