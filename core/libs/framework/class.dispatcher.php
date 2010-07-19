<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class Dispatch
 */

class Dispatcher {
	
	private $router;
	private $url;
	private $map;
	
	public static function dispatch() {
		new self();
	}
	
	function __construct() { 
		$this->router 	= Router::load();
		$this->url 		= $this->get_url();
		
		$this->map = $this->router->apply($this->url);
		$this->delegate();
	}
	
	private function get_url() {
		$url = $_GET['url'];
		$vars = array();
		
		foreach($_GET as $k=>$v) {
			if($k != 'url') {
				array_push($vars, $k . '=' . $v);
			}
		}
		
		if(!empty($vars)) {
			if(strpos($url, '?') > 0) {
				$url .= '&' . implode('&', $vars);
			} else {
				$url .= '?' . implode('&', $vars);
			}
		}

		return urldecode($url);
	}
		
	private function delegate() {
		$controller = String::camelize($this->map['controller']) . 'Controller';
		
		if (!class_exists($controller)) {
			trigger_error("Route Error: The class `{$controller}` does't appear to be valid.", E_USER_ERROR);
		}
		
		$klass = new $controller ($this->map['params']);
		
		if(!method_exists($klass, $this->map['action'])) {
			trigger_error("Route Error: The method `{$this->map['action']}` does't appear to be valid.", E_USER_ERROR);
		}
		
		call_user_func_array(array($klass, $this->map['action']), array());
		
		new ActionView($klass, $this->map);
		
	}
	
}

?>