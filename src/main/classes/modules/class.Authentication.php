<?php

class Authentication
{
	static private $_authenticated = false; 
	
	static public function authenticate() {
		$username = Encryption::get('username');
		$password = Encryption::get('password');
		
		echo "<br>decrypted: $username : $password<br>";

		$mapiSession = mapi_logon_zarafa($username, $password, ZARAFA_SERVER);
		echo "login ". ($mapiSession==false?'failed':'succeeded').'<br>';

		Authentication::$_authenticated = true;
		return $mapiSession != false;
	}

	static public function login($username, $password) {
		// Login to MAPI to check credentials
		$mapiSession = mapi_logon_zarafa($username, $password, ZARAFA_SERVER);
		if ($mapiSession == false) {
			return false;
		}

		Encryption::add('username', $username);
		Encryption::add('password', $password);
		
		Authentication::$_authenticated = true;
	}
	
	static public function authenticated() {
		return Authentication::$_authenticated == true;
	}
}
