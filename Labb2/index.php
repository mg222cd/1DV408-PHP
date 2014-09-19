<?php

require_once("src/view/HTMLPage.php");
require_once("src/view/LoginView.php");
require_once("src/controller/LoginController.php");

session_start();

$title = "Laborationskod mg222cd";
$body = "<h1>Laborationskod mg222cd</h1>";

$pageView = new \view\HTMLPage();

$loginController = new \controller\LoginController();
$body .= $loginController->doControll();

echo $pageView->getPage($title, $body);