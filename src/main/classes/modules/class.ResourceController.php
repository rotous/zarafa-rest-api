<?php

abstract class ResourceController
{
	public $requestMethod;
	
	public function __construct($request) {
		$this->requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
		
		if ( !$this->_authenticated() ){
			// Return unauthorised response
			echo "Unauthorised<br>";
			return;
		}
		
		$this->_run($request);
	}
	
	private function _authenticated() {
		$auth = new Authentication();
		
		return $auth->isAuthenticated();
	}
	
	protected function _run($request) {
		
	}
	
	abstract public function getUrl();
}
