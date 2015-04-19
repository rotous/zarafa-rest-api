<?php 

class MainController {
	public function __construct(){
		Session::start();
		
		$request_url = trim($_GET['request_url'], '/');
		unset($_GET['request_url']);

		$request = explode('/', $request_url);
		
		$this->_run($request);
	}
	
	private function _run($request) {
		if ( isset($request[0]) && $request[0] ){
			$mainRequestComponent = strtolower(array_shift($request));
			$controllerName = ucfirst($mainRequestComponent).'ResourceController';
			if ( class_exists($controllerName, true) ){
				$subController = new $controllerName($request);
			} else {
				// TODO return error response
				echo "Bad request. Unknown resource";
			}
		}else{
			// The main entry point of the api was requested
			echo "main entry point";
		}
	}
	
	private function _buildResponse() {
		
	}
	
}
