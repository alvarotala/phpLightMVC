<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class Session
 */

class Session {
	
	static function set($key, $value) {
		if(empty($_SESSION[_SESSION_NAME])) $_SESSION[_SESSION_NAME] = array();
		
		$_SESSION[_SESSION_NAME][$key] = $value;
		return $value;
	}
	
	static function get($key) {
		return $_SESSION[_SESSION_NAME][$key];
	}
	
	static function array_set($name, $key, $value) {
		if(empty($_SESSION[_SESSION_NAME])) $_SESSION[_SESSION_NAME] = array();
		if(empty($_SESSION[_SESSION_NAME][$name])) $_SESSION[_SESSION_NAME][$name] = array();
		
		$_SESSION[_SESSION_NAME][$name][$key] = $value;
		return $value;
	}
	
	static function array_get($name) {
		return $_SESSION[_SESSION_NAME][$name];
	}
	
	static function remove($name) {
		return $_SESSION[_SESSION_NAME][$name] = null;
	}
	
	static function destroy($name) {
		unset($_SESSION[_SESSION_NAME][$name]);
	}
	
}
?>