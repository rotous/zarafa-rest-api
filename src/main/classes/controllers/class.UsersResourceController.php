<?php

require_once "3rdparty/phpcrypt/phpCrypt.php";
use PHP_Crypt\PHP_Crypt as PHP_Crypt;

class UsersResourceController extends ResourceController
{
	public function __construct($request) {
		$this->_setRequestMethod();
		
		$this->_run($request);
	}

	protected function _run($request) {
		if ( $this->requestMethod == 'POST' && count($request)==0 ){
			// User tries to login
			Authentication::login($_POST['username'], $_POST['password']);
			
			if ( !Authentication::authenticated() ){
				Headers::sendStatusUnauthorized();
				return;
			}else{
				Headers::sendStatusOk();
				echo "login succeeded<br>";
				return;
			}
		} else {
			Authentication::authenticate();
			
			if ( !Authentication::authenticated() ){
				Headers::sendStatusUnauthorized();
				return;
			}

		 	if ( $this->requestMethod == 'GET' && count($request)>0 ){
				// User info requested
				echo "requesting userinfo of user ".$request[0];
			}else{
				// Bad request
				Headers::sendStatusMethodNotAllowed();
				echo "Method not allowed<br>";
				print_r($request);
			}
		}
	}
	
	public function getUrl() {
		return '/login';
	}
}
