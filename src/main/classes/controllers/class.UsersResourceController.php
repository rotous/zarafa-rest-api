<?php

class UsersResourceController extends ResourceController
{

	protected function _run($request) {
		if ( $this->requestMethod == 'POST' ){
			// User tries to login
			$this->_login();
		}elseif ( $this->requestMethod == 'GET' && count($request)>0 ){
			// User info requested
			echo "requesting userinfo of user ".$request[0];
		}else{
			// Bad request
			Headers::sendStatusMethodNotAllowed();
			echo "Method not allowed<br>";
			print_r($request);
		}
	}
	
	private function _login() {
		// find username and password from POST
		$username = $_POST['username'];
		$password = $_POST['password'];
		
		// Login to MAPI to check credentials
		
		// Store username and password in session if okay
		
		Headers::sendStatusUnauthorized();
		echo json_encode(array(
			'error' => array(
				'code' => 401,
				'message' => 'Unable to login. User not found.'
			)
		), JSON_PRETTY_PRINT);
		
		return false;
	}
	
	public function getUrl() {
		return '/login';
	}
}
