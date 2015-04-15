<?php
/**
 * This file bootstraps the application by defining some functions
 */

ini_set("display_errors", true);
error_reporting(E_ALL);
 
//$path = __DIR__ . PATH_SEPARATOR . __DIR__.'/../classes' . PATH_SEPARATOR . __DIR__.'/../mapi';
//set_include_path(get_include_path() . PATH_SEPARATOR . $path);

$classBaseDir = __DIR__ . '/../classes/';
$classDirs = array('.');

function findSubdirs ($dirName){
	global $classBaseDir;
	global $classDirs;
	
	$files = scandir($classBaseDir.$dirName);
	foreach ( $files as $file ){
		if ( is_dir($classBaseDir.$dirName.'/'.$file) && $file!=='.' && $file!='..' ){
			$classDirs[] = $dirName.'/'.$file;
			findSubdirs($dirName.'/'.$file);
		}
	}
}
findSubdirs('.');

function __autoload($className){
	global $classBaseDir;
	global $classDirs;

	foreach ($classDirs as $dir){
		if ( file_exists($classBaseDir.$dir.'/class.'.$className.'.php') ){
			include_once($classBaseDir.$dir.'/class.'.$className.'.php');
			return;
		}else if ( file_exists($classBaseDir.$dir.'/class.'.strtolower($className).'.php') ){
			include_once($classBaseDir.$dir.'/class.'.strtolower($className).'.php');
			return;
		}
	}
}

// TODO: Test if this works with older PHP versions
if ( !defined('JSON_PRETTY_PRINT') ){
	define('JSON_PRETTY_PRINT', 128);
}

// TODO: move this to a config file or a textfile in which it will be created if it does not exist yet.
$GLOBALS['applicationkey'] = 'a2#fd&x-g';

// TODO: Remove this if not debugging/developing
if ( $_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['method']) && strtoupper($_GET['method'])=='POST' ){
	$_SERVER['REQUEST_METHOD'] = 'POST';
	$_POST = $_GET;
}
