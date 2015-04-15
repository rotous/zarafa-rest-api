<?php

class FoldersResourceController extends ResourceController
{
	
	public function __construct ($request){
		parent::__construct($request);
	}
	
	protected function _run($request){
		$firstRequestComponent = array_shift($request);
		if ( $firstRequestComponent ){
			echo "<br>sending more than folders";
		}else{
			echo "<br>sending folders";
		}
	}
	
	public function getUrl() {
		return '/folders';
	}
}
