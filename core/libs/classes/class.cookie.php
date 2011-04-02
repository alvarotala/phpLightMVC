<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class Cookie
 */

class Cookie {
	
	static function set($key, $value, $expire=null) {
		if($expire==null) $expire = time(); # default now..
		$_COOKIE[$key] = $value;
		
		setcookie($key, $value, $expire, "/", '.'.DOMAIN);
		return $value;
	}
	
	static function get($key) {
		return $_COOKIE[$key];
	}
	
	static function destroy($key) {
		unset($_COOKIE[$key]);
	}
	
}
?>