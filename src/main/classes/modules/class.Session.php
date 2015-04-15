<?php

class Session
{
	static private $_instance;
	private $_sessionName;
	private $_sessionId; 
	
	private function __construct() {
		if ( defined('SESSION_NAME') ){
			$this->_sessionName = SESSION_NAME;
		}else{
			$this->_sessionName = 'ZARAFA_REST_API_SESSION';
		}
		
		session_name($this->_sessionName);
		session_start();
		session_regenerate_id();
	}
	
	static public function getInstance() {
		if ( !Session::$_instance ){
			Session::$_instance = new Session();
		}
		
		return Session::$_instance;
	}
}
