<?php
namespace Controller;

require_once('./View/LoginView.php');
require_once('./Model/UserModel.php');
require_once('./View/LoggedinView.php');
require_once('./View/CookieView.php');
require_once('./View/RegisterView.php');
require_once('./Helpers/ServiceHelper.php');
//require_once('./Model/UserRepository.php');

class LoginController{

    private $loginView;
    private $userModel;
    private $loggedInView;
    private $cookieView;
    private $serviceHelper;
    private $registerView;
    //private $userRepository;

    public function __construct(){
        $this->loginView = new \View\LoginView();
        $this->userModel = new \Model\UserModel();
        $this->loggedInView = new \View\LoggedInView();
        $this->cookieView = new \View\CookieStorage();
        $this->serviceHelper = new \Helper\ServiceHelper();
        $this->registerView = new \View\RegisterView();
        //$this->userRepository = new \Model\UserRepository();
    }

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
    * either by button-click (username and password), session or cookies
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
                    $this->userModel->saveCookieTime($time);
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
}