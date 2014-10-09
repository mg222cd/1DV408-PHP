<?php

require_once('View/HTMLView.php');
require_once('Controller/MasterController.php');

session_start();

$htmlView = new \View\HTMLView();
$masterController = new \Controller\MasterController();

$content = $masterController->controlNavigation();
$htmlView->echoHTML($content);

