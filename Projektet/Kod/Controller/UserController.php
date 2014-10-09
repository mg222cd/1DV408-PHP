<?php

namespace Controller;

require_once("./View/LoginView.php");
require_once("./View/RegisterView.php");
require_once("./Model/UserModel.php");
require_once(".//Model/UserRepository.php");

class UserController{

	private $loginView;
	private $registerView;
	private $userModel;
	private $userRepository;

	public function __construct(){
		$this->loginView = new \View\LoginView();
		$this->registerView = new \View\RegisterView();
		$this->userModel = new \Model\UserModel();
		$this->userRepository = new \Model\UserRepository();
	}
	
	public function controlRegistration(){

		//Om användaren försökt skicka registreringsuppgifter
            if ($this->registerView->confirmedRegister() == TRUE) {
                    $checkUsername = $this->userModel->validateUsername($this->registerView->getUsername());
                    $checkPassword = $this->userModel->validatePassword($this->registerView->getPassword());
                    $checkEmail = $this->userModel->validateEmail($this->registerView->getUsername());
                    if ($checkEmail && $checkUsername && $checkPassword == TRUE) {
                        //kontrollera att lösenordsfälten matchar
                        $password = $this->registerView->getPassword();
                        $passwordRepeat = $this->registerView->getPasswordRepeat();
                        if ($password != $passwordRepeat) {
                            $this->registerView->setPasswordMismatch();
                        } 
                        else {
                            //Kontrollera så att användarnamnet är ledigt
                            if ($this->userModel->nameAlreadyExists($this->registerView->getUsername()) == TRUE) {
                                $this->registerView->setUsernameAlreadyExists();
                            } 
                            else {
                                //Filtrera användarnamn från skadlig kod
                                $strippedUsername = $this->userModel->stripTags($this->registerView->getUsername());
                                if ($strippedUsername != NULL) {
                                    $this->registerView->setInvalidUsername($strippedUsername);
                                } else {
                                    $encryptedPassword = $this->userModel->encryptPassword($this->registerView->getPassword());
                                    if ($this->userRepository->add($this->registerView->getUsername(), $encryptedPassword) == TRUE) {
                                        $this->loginView->setMessage("Registrering av ny användare lyckades.");
                                        return $this->loginView->loginForm();
                                    } 
                                }
                            }
                        }
                    }
                    else{
                        if (!$checkUsername) {
                            $this->registerView->setWrongUsername($this->userModel->getMinLengthUsername());
                        }
                        if (!$checkPassword) {
                            $this->registerView->setWrongPassword($this->userModel->getMinLengthPassword());
                        }
                        if (!$checkEmail) {
                            $this->registerView->setWrongEmail();
                        }
                    }
            return $this->registerView->registerForm();
            }
            else{
            	return $this->registerView->registerForm();
            }

	}
}