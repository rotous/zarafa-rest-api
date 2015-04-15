<?php

class MapiMessage
{
	private $_properties = array(
		'entryid' => '',
		'parent_entryid' => '',
		'store_entryid' => ''
	);
	
	public function __construct(){
		
	}
	
	protected function addProperties($newProperties) {
		if ( !is_array($newProperties) ){
			return false;
		}
		
		foreach ( $newProperties as $prop => $value ){
			if ( !key_exists($prop, $this->_properties) ){
				$this->_properties[$prop] = $value;
			}
		}
		
		return true;
	}
}
