<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class ActionView
 */

class ActionView {
	
	public function __construct($controller, $map) {
		$this->controller = $controller;
		$this->map = $map;
		
		$Render = $this->controller->getRender();
		if($Render !== false) {
			if($Render === true) {
				$this->renderView();
			} else {
				if(is_array($Render)) {
					if(!$Render[1]) $Render[1] = 'text/html';

					header('Content-type: ' . $Render[1]);
					echo $Render[0];
				} else {
					trigger_error("Error: Action view render must be an array.", E_USER_ERROR);
				}
			}
		}
	}
		
	private function __get($var) { 
		return $this->controller->$var;
	}
	
	private function renderView() {
		$path = APP_PATH . '/views/' . $this->map['controller'] . '/' . $this->map['action'] . '.php';
		if(!file_exists($path)) {
			trigger_error("Route Error: Can't find the view `{$path}`.", E_USER_ERROR);
		}
		
		require_once $path;
	}

}
?>