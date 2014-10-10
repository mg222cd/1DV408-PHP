<?php

require_once('View/HTMLView.php');
require_once('Controller/MasterController.php');
//require_once('./Controller/LoginController.php');

session_start();

$htmlView = new \View\HTMLView();
$masterController = new \Controller\MasterController();

$content = $masterController->controlNavigation();

//$loginController = new\Controller\LoginController();
//$testContent = $loginController->doControl();
$htmlView->echoHTML($content);

