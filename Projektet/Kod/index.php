<?php

require_once('View/HTMLView.php');
require_once('Controller/MasterController.php');

$htmlView = new \View\HTMLView();
$masterController = new \Controller\MasterController();

$content = $masterController->controlNavigation();
$htmlView->echoHTML($content);


//Classes and functions
/* 
 * Description: MasterController controls the applications overall scenarios 
 */ 

/* 
 * Description: Determinds the page content
 *
 * @return string (generatet from different view-functions)
 */ 

//Variables
/*
 * Eventuellt beskrivning
 * @var string
 */
