<?php

class Headers
{
	public static function sendStatusOk() {
		http_response_code(200);
	}
	
	public static function sendStatusNotFound() {
		http_response_code(404);
	}

	public static function sendStatusBadRequest() {
		http_response_code(400);
	}
	
	public static function sendStatusUnauthorized() {
		http_response_code(401);
		header('WWW-Authenticate: None');
	}
	
	public static function sendStatusMethodNotAllowed() {
		http_response_code(405);
	}
	
}
