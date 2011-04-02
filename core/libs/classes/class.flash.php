<?
class Flash {
	
	static function notice($message) {
		Session::array_set('flash', 'notice', $message);
	}
	
	static function error($message) {
		Session::array_set('flash', 'error', $message);
	}
		
	static function get($name) {
		$flash = Session::array_get('flash');
		$flash = $flash[$name];
		
		if(isset($flash) && !empty($flash)) {
			return $flash;
		}
	}
	
	static function show() {
		$message = self::get('notice');
		if(!empty($message)) {
			echo "<div class='flash notice'>{$message}</div>";
		}
		
		$message = self::get('error');
		if(!empty($message)) {
			echo "<div class='flash error'>{$message}</div>";
		}
		
		Session::destroy('flash');
	}
	
}
?>