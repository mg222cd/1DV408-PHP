<?php

require_once("src/view/HTMLPage.php");
require_once("src/view/LoginView.php");

$title = "Labb 2 - Login del 1.";
$body = "<h1>Labb 2 - Login del 1.</h1>";

$pageView = new \view\HTMLPage();

echo $pageView->getPage($title, $body);

//TA BORT NÄR när koden kommer ut via controller istället.
//$testLogin = new \view\LoginView();
//echo $testLogin->DoLoginPage();

$loginController = new \controller\LoginController();

//LÄGG TILL NÄR LoginControllern är klar
//echo $pageView->getPage($title, $body) .= $loginController->DoControll();

//TODO
//Lägg till self::$variabler i formuläret (se skärmdump)