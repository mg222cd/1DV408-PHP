<?php

require_once('./View/LoginView.php');
require_once('./Model/UserModel.php');
require_once('./View/LoggedinView.php');
require_once('./View/CookieView.php');
require_once('./View/RegisterView.php');
require_once('./Helpers/ServiceHelper.php');
require_once('./Model/UserRepository.php');

class LoginController{
    private $loginView;
    private $userModel;
    private $loggedInView;
    private $cookieView;
    private $serviceHelper;
    private $registerView;
    private $userRepository;

    public function __construct(){
        $this->loginView = new LoginView();
        $this->userModel = new UserModel();
        $this->loggedInView = new LoggedInView();
        $this->cookieView = new CookieStorage();
        $this->serviceHelper = new ServiceHelper();
        $this->registerView = new RegisterView();
        $this->userRepository = new UserRepository();
    }

    public function doControl(){
        $userAgent = $this->serviceHelper->getUserAgent();

        /*När användaren trycker på logga in knappen så hämtas information ut om vad användaren skrev in för lösenord och
        användarnamn och skickar den vidare för att kontrollera om dem är korrekta och i sådana fall loggas man in annars
        visas ett felmeddelande.
        Vill användaren att man ska komma ihåg den så skapas en cookie och sparar en identifierare i cookien så att man vet
        vilken användare som är inloggad. */
        if($this->loginView->getSubmit()){
            $this->loginView->getInformation();
            $username = $this->loginView->getUsername();
            $password = $this->loginView->getPassword();
            $realAgent = $this->serviceHelper->getUserAgent();
            if(!$this->userModel->validateLogin($username, $password, $realAgent)){
                $this->loginView->failedLogIn($username, $password);
            }
            else {
                if($this->loginView->wantCookie()){
                    $randomString = $this->userModel->getRandomString();
                    $time = $this->cookieView->save($randomString);
                    $this->userModel->saveCookieTime($time);
                    $message = $this->cookieView->cookieSaveMessage();
                    $this->loggedInView->setMessage($message);
                }
                else{
                    $message = $this->loginView->LogInSuccessMessage();
                    $this->loggedInView->setMessage($message);
                }
            }
        }

        /*Tittar om användaren redan är inloggad med sessioner och om den inte är det så laddas cookie in och kollar om
        det finns och om det inte gör det så visas ett felmeddelande, men om cookie skulle finnas på klienten så jämförs
        dem och tittar så att identifieraren i cookien stämmer överens med den på servern och om de gör det så loggas man
        in annars visas ett felmeddelande.*/
        $authenticated = $this->userModel->getAuthenticatedUser($userAgent);
        if($authenticated === false){
            if($this->cookieView->loadCookie()){
                $cookieValue = $this->cookieView->cookieExist();
                if($this->userModel->controlCookieValue($cookieValue, $userAgent)){
                    $message = $this->cookieView->cookieLoadMessage();
                    $this->loggedInView->setMessage($message);
                }
                else{
                    $this->cookieView->deleteCookie();
                    $message = $this->cookieView->cookieModifiedMessage();
                    $this->loginView->setMessage($message);
                }
            }
        }

        /*Om användaren är inloggad ska anvämdaren kunna logga ut och om den trycker på logga ut så tas cookien bort om de
        finns på klienten tillsammans med sessionen och man får ett meddelande att man har loggat ut. */
        $authenticated = $this->userModel->getAuthenticatedUser($userAgent);
        if($authenticated === true){
            $userLogOut = $this->loggedInView->userPressedLogOut();
            if($userLogOut === true){
                $this->cookieView->deleteCookie();
                $message = $this->loggedInView->logOutSuccessMessage();
                $this->loginView->setMessage($message);
                $this->userModel->LogOut();
            }
        }

        $loginView = $this->loginView->ViewLogin();

        $loggedInView = $this->loggedInView->LoggedInView();
        $authenticated = $this->userModel->getAuthenticatedUser($userAgent);

        if($authenticated === true){
            //Returnerar den inloggade vyn.
            return $loggedInView;
        }
        else{
            //Om användaren försökt skicka registreringsuppgifter
            if ($this->registerView->confirmedRegister() == TRUE) {
                    $checkUsername = $this->userModel->validateUsername($this->registerView->getUsername());
                    $checkPassword = $this->userModel->validatePassword($this->registerView->getPassword());
                    if ($checkUsername && $checkPassword == TRUE) {
                        //kontrollera att lösenordsfälten matchar
                        $password = $this->registerView->getPassword();
                        $passwordRepeat = $this->registerView->getPasswordRepeat();
                        var_dump($password, $passwordRepeat);
                        if ($password != $passwordRepeat) {
                            $this->registerView->setPasswordMismatch();
                        } 
                        else {
                            //Kontrollera så att användarnamnet är ledigt
                            if ($this->userModel->nameAlreadyExists($this->registerView->getUsername()) == TRUE) {
                                $this->registerView->setUsernameAlreadyExists();
                            } 
                            else {
                                echo "Username ledigt, hurra hurra, fortsätt med koden och lägg till användaren.";
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
                    }
            }
            //Om användaren tryckt på Registrera
            if ($this->loginView->clickedRegister()) {
                return $this->registerView->registerForm();
            }
            return $loginView;
        }
    }
}