<?php

namespace Controller;

require_once("./View/LoginView.php");
require_once("./View/RegisterView.php");
require_once("./Model/UserModel.php");
require_once(".//Model/UserRepository.php");

/**
* Controller class for registration scenarios
*/
class UserController{
    //instances
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

		//User tried to Confirm registration
            if ($this->registerView->confirmedRegister() == TRUE) {
                    $checkUsername = $this->userModel->validateUsername($this->registerView->getUsername());
                    $checkPassword = $this->userModel->validatePassword($this->registerView->getPassword());
                    $checkEmail = $this->userModel->validateEmail($this->registerView->getUsername());
                    if ($checkEmail && $checkUsername && $checkPassword == TRUE) {
                        //validate passwords match
                        $password = $this->registerView->getPassword();
                        $passwordRepeat = $this->registerView->getPasswordRepeat();
                        if ($password != $passwordRepeat) {
                            $this->registerView->setPasswordMismatch();
                        } 
                        else {
                            //validate username is available
                            if ($this->userModel->nameAlreadyExists($this->registerView->getUsername()) == TRUE) {
                                $this->registerView->setUsernameAlreadyExists();
                            } 
                            else {
                                //filtrate username
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
                        //error messages
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
            }
            return $this->registerView->registerForm();
	}
}