<?php

class Session
{
	static private $_started = false;
	static private $_open = false;
	static private $_sessionName;
	static private $_sessionId; 
	
	static public function start() {
		if ( !Session::$_started) {
			if ( defined('SESSION_NAME') ){
				Session::$sessionName = SESSION_NAME;
			}else{
				Session::$_sessionName = 'ZARAFA_REST_API_SESSION';
			}
			
			session_name(Session::$_sessionName);
			Session::open();
			session_regenerate_id();
			Session::$_started = true;
		} else {
			Session::open();
		}
	}
	
	static public function save($key, $value) {
		$_SESSION[$key] = $value;
	}
	
	static public function open() {
		if ( !Session::$_open ){
			session_start();
			Session::$_open = true;
		}
	}
	
	static public function close() {
		if ( Session::$_open ){
			session_write_close();
		}
	}
	
	static public function destroy() {
		session_destroy();
	}
}
