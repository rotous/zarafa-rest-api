<?php

require_once "3rdparty/phpcrypt/phpCrypt.php";
use PHP_Crypt\PHP_Crypt as PHP_Crypt;

class Encryption
{
	static private $_keyName = 'zpek';
	static private $_ivName = 'ziv';
	
	static private function _getKey() {
		if ( defined('APPLICATION_ENCRYPTION_KEY') && strlen(APPLICATION_ENCRYPTION_KEY)>7 ){
			$keyPart1 = substr(APPLICATION_ENCRYPTION_KEY, 0, 8);
		}else{
			$keyPart1 = PHP_Crypt::createKey(PHP_Crypt::RAND, 16);
			$keyPart1 = '';
		}
		if ( isset($_COOKIE[Encryption::$_keyName]) ){
			$keyPart2 = $_COOKIE[Encryption::$_keyName];
		}else{
			// Create a new key and store it in the cookie
			$keyPart2 = PHP_Crypt::createKey(PHP_Crypt::RAND, $keyPart1 ? 8 : 16);
			// TODO: add cookie settings
			echo "setting zpek cookie<br>";
			setcookie(Encryption::$_keyName, $keyPart2);
		}
		
		return $keyPart1.$keyPart2;
	}
	
	static private function _setIV($crypt) {
		Session::start();
		
		if ( isset($_SESSION[Encryption::$_ivName]) ){
			$iv = $_SESSION[Encryption::$_ivName];
			$crypt->IV($iv);
		} else {
			$iv = $crypt->createIV(PHP_Crypt::RAND_DEV_RAND);
			$_SESSION[Encryption::$_ivName] = $iv;
		}
		
		return $iv;
	}
	
	static public function encrypt($value) {
		$key = Encryption::_getKey();		
		$crypt = new PHP_Crypt($key, PHP_Crypt::CIPHER_AES_128, PHP_Crypt::MODE_CBC);
		Encryption::_setIV($crypt);

		$encryptedValue = $crypt->encrypt($value);
		
		return $encryptedValue;
	}
	
	static public function decrypt($encryptedValue) {
		$key = Encryption::_getKey();		
		$crypt = new PHP_Crypt($key, PHP_Crypt::CIPHER_AES_128, PHP_Crypt::MODE_CBC);
		Encryption::_setIV($crypt);

		$value = $crypt->decrypt($encryptedValue);
		
		return $value;
	}
	
	static public function add($key, $value) {
		$encryptedValue = Encryption::encrypt($value);

		if ( !isset($_SESSION['encryption_store']) ) {
			$_SESSION['encryption_store'] = array();
		}
		$_SESSION['encryption_store'][$key] = $encryptedValue;
	}
	
	static public function remove($key) {
		Session::start();

		if ( !isset($_SESSION['encryption_store']) || !isset($_SESSION['encryption_store'][$key]) ){
			return;
		}
		
		$encryptedValue = $_SESSION['encryption_store'][$key];
		unset($_SESSION['encryption_store'][$key]);
		
		return $encryptedValue;
	}
	
	static public function get($key) {
		Session::start();

		if ( !isset($_SESSION['encryption_store']) || !isset($_SESSION['encryption_store'][$key]) ){
			return null;
		}
		$encryptedValue = $_SESSION['encryption_store'][$key];
		$value = Encryption::decrypt($encryptedValue);
		
		return $value;		
	}
	
	/**
	 * Will retrieve all stored encrypted values, decrypt them, 
	 * and encrypt them again with a new key, and store them again. 
	 */
	static public function reEncryptAll() {
		Session::start();
		
		if ( !isset($_SESSION['encryption_store']) ){
			return;
		}
		
		$encryptionStore = $_SESSION['encryption_store'];
		$_SESSION['encryption_store'] = array();
		
		foreach ($encryptionStore as $key => $encryptedValue){
			$encryptionStore[$key] = Encryption::decrypt($encryptedValue);
		}

		// Remove the key and the initialization vector, so they will be
		// created again by the encrypt method.
		unset($_COOKIE[Encryption::$_keyName]);
		unset($_SESSION[Encryption::$_ivName]);

		foreach ($encryptionStore as $key => $value){
			$_SESSION['encryption_store'][$key] = Encryption::decrypt($value);
		}
	}
}
