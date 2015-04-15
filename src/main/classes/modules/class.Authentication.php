<?php

class Authentication
{
	public function __construct() {
		$session = Session::getInstance();
	}
	
	public function authenticate($username, $password) {
		
	}
	
	public function isAuthenticated() {
		return true;
	}
}
