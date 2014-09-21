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
			$status = "";
			$body = "";
			$messages = "";
			$datetime = $this->loginView->getDateAndTime();

			//hantering loginscenarion
			if ($this->loginView->triedToLogout()) {
					$messages = $this->loginModel->doLogout();
			}
			//scenario - användaren är redan inloggad
			//...via cookies
			if ($this->loginCookieView->getCookieName() != NULL && $this->loginCookieView->getCoookiePassword() != NULL) {
				//säkerhetskontroll 
				$stringToVerify = $this->loginCookieView->pickupCookieInformation($this->loginCookieView->getCoookiePassword());
				//jämför strängen mot dem i filen
				if ($this->loginModel->cookieSecurityCheck($stringToVerify) == TRUE) {
					$body = $this->loginView->loggedInPage();
					$name = $this->loginCookieView->getCookieName();
					$status = "<h2>" . $name . " är inloggad</h2>";
					$messages = "Inloggning lyckades via cookies";
						if ($this->loginView->triedToLogout() == TRUE) {
							$this->loginModel->removeClientIdentifier($this->loginCookieView->getCookieName());
							$this->loginCookieView->removeCookie();
							$messages = $this->loginModel->doLogout();
							$body = $this->loginView->doLoginPage();
						}
				} else {
					$body = $this->loginView->doLoginPage();
					$messages = "Felaktig information i cookie";
					$status = "<h2>Ej inloggad</h2>";
					$this->loginCookieView->removeCookie();
					$this->loginModel->doLogout();
				}
			}
			//...via sessionen
			else if ($this->loginModel->isLoggedIn() == TRUE) {
				$name = $_SESSION['name'];
				$status = "<h2>" . $name . " är inloggad</h2>";
				$body = $this->loginView->loggedInPage();
				if ($this->loginView->triedToLogout()) {
					$messages = $this->loginModel->doLogout();
					var_dump($_SESSION);
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
							$name = $this->loginCookieView->getCookieName();
							$status = "<h2>" . $name . " är inloggad</h2>";
							$messages = "<p>Inloggning lyckades och vi kommer ihåg dig nästa gång</p>";
							$body = $this->loginView->loggedInPage();
						}
						//inloggning utan ikryssad ruta
						else{
						$name = $this->loginModel->getSessionName();
						$status = "<h2>" . $name . " är inloggad</h2>";
						$messages = "<p>Inloggningen lyckades</p>";
						$body = $this->loginView->loggedInPage();
						}
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
				//Säkerhetskontroll för att undvika sessionsstöld
				if ($this->loginModel->cookieSecurityCheck($this->loginView->getClientIdentifier()) == TRUE ) {
					$this->loginModel->isLoggedIn();
					$body = $this->loginView->loggedInPage();
				}
				else{
					return NULL;
				}
				//kontroll om användaren tryckt på logout
				if ($this->loginView->triedToLogout() == TRUE) {
					$messages = $this->loginModel->doLogout();
					$this->loginModel->removeClientIdentifier($this->loginCookieView->getCookieName());
					$this->loginView->removeCookie($this->loginView->getName(), $this->loginView->getPassword());
					$body = $this->loginView->doLoginPage();
				}
			}
			return $status . $messages . $body . $datetime;
	}
}