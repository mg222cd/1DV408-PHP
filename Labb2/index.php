<?php

require_once("src/view/HTMLPage.php");
require_once("src/view/LoginView.php");
require_once("src/controller/LoginController.php");

$title = "Labb 2 - Login del 1.";
$body = "<h1>Labb 2 - Login del 1.</h1>";

$pageView = new \view\HTMLPage();

$loginController = new \controller\LoginController();
$body .= $loginController->doControll();

echo $pageView->getPage($title, $body);