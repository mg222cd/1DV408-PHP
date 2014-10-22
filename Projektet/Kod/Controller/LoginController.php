<?php
namespace Controller;

require_once('./View/LoginView.php');
require_once('./Model/UserModel.php');
require_once('./View/CookieView.php');
require_once('./Helpers/ServiceHelper.php');

class LoginController{
    //instances
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
    * @return string with HTML-text
    */

    public function mainController(){
        $userAgent = $this->serviceHelper->getUserAgent();
        //if user clicked login-button
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
        //Validate ordinary login
        $username = $this->loginView->getUsername();
        $password = $this->loginView->getPassword();
        $realAgent = $this->serviceHelper->getUserAgent();
        if($this->userModel->validateLogin($username, $password, $realAgent)){
                $this->loginView->failedLogIn($username, $password);
                //in case of set cookies
                if($this->loginView->wantCookie()){
                    $time = $this->cookieView->save($username);
                    $this->userModel->setTime($time);
                }
                return TRUE;
        }
        //Validate login with session
        if ($this->userModel->getAuthenticatedUser($realAgent)) {
            return TRUE;
        }
        //Validate login with cookies
        if($this->cookieView->loadCookie()){ //if there is cookie
            $cookieValue = $this->cookieView->cookieExist(); //value of cookie
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

    /**
    * Tasks to do if user clicked Logout button.
    */
    public function logoutTasks(){
        $this->cookieView->deleteCookie();
        $this->userModel->logout();
    }
}

/**
* @author Marike Grinde
*/