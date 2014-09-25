<?php

require_once('View/HTMLView.php');
require_once('Controller/LoginController.php');

$view = new HTMLView();
$login = new LoginController();

$viewLogin = $login->doControl();
$view->echoHTML($viewLogin);