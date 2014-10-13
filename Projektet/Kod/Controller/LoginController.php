<?php
namespace Controller;

require_once('./View/LoginView.php');
require_once('./Model/UserModel.php');
require_once('./View/CookieView.php');
require_once('./Helpers/ServiceHelper.php');

class LoginController{

    private $loginView;
    private $userModel;
    private $cookieView;
    private $serviceHelper;


    public function __construct(){
        $this->loginView = new \View\LoginView();
        $this->userModel = new \Model\UserModel();
        $this->cookieView = new \View\CookieStorage();
        $this->serviceHelper = new \Helper\ServiceHelper();
    }

    /**
    * Maincontroller for login page scenario
    *
    * @return string with HTML
    */

    public function mainController(){
        $userAgent = $this->serviceHelper->getUserAgent();
        //om användaren klickat på Logga in-knappen
        if($this->loginView->getSubmit()){
            if(!$this->validLogin()){
                $this->loginView->failedLogIn($this->loginView->getUsername(), $this->loginView->getPassword());
            }
        }
        return $this->loginView->loginForm();
    }

    /**
    * If tryed to login - this function makes sure that the login is valid,
    * either by username and password, session or cookies
    *
    * @return bool
    */
    public function validLogin(){
        //Kontrollera vanlig inloggning
        $username = $this->loginView->getUsername();
        $password = $this->loginView->getPassword();
        $realAgent = $this->serviceHelper->getUserAgent();
        if($this->userModel->validateLogin($username, $password, $realAgent)){
                $this->loginView->failedLogIn($username, $password);
                //om Cookies ska sättas
                if($this->loginView->wantCookie()){
                    $time = $this->cookieView->save($username);
                    $this->userModel->setTime($time);
                    //$this->userModel->saveCookieTime($time);
                }
                return TRUE;
        }
        //Kontrollera inloggning med session
        if ($this->userModel->getAuthenticatedUser($realAgent)) {
            return TRUE;
        }
        //Kontrollera inloggning med cookies
        if($this->cookieView->loadCookie()){ //om kaka finns
            $cookieValue = $this->cookieView->cookieExist(); //Kakans värde
            if(!$this->userModel->controlCookieValue($cookieValue, $realAgent)){
                $this->cookieView->deleteCookie();
                $message = $this->cookieView->cookieModifiedMessage();
                $this->loginView->setMessage($message);
            }
            else{
                return TRUE;
            }
        }
        return FALSE;
    }

    public function logoutTasks(){
        $this->cookieView->deleteCookie();
        $this->userModel->logout();
    }
}