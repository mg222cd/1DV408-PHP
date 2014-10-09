<?php
namespace Controller;

require_once("./Controller/LoginController.php");


class MasterController{


/**
 * Creates new instances of loginview, 
 */
public function __construct(){
	
}
	/** 
 	 * Determinds the page content depending on URL
	 *
 	 * @return string (generatet from different view-functions)
	 */ 
	public function controlNavigation(){
		$loginController = new \Controller\LoginController();
		return $loginController->doControl();
	}

}

