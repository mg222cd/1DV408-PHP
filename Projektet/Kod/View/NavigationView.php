<?php
namespace View;

class NavigationView{
	private static $action = 'action';
	public static $actionSignIn = 'signIn';

	public static $actionRegister = 'register';
	public static $actionLoggedIn = 'loggedIn';
	public static $actionSignOut = 'signOut';

	public static function getAction(){
		if (isset($_GET[self::$action])){
			return $_GET[self::$action];
		}
		return self::$actionSignIn;
	}
}