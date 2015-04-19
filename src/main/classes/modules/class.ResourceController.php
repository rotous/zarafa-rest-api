<?php

abstract class ResourceController
{
	public $requestMethod;
	
	public function __construct($request) {
		$this->_setRequestMethod();
		
		Authentication::authenticate();

		if ( !Authentication::authenticated() ){
			// Return unauthorised response
			Headers::sendStatusUnauthorised();
			echo "Unauthorised<br>";
			return;
		}
		
		$this->_run($request);
	}
	
	protected function _setRequestMethod() {
		$this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
	}
	
	private function _authenticated() {
		$auth = new Authentication();
		
		return $auth->isAuthenticated();
	}
	
	protected function _run($request) {
		
	}
	
	abstract public function getUrl();
}
