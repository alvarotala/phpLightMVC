<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class ActionController
 */

class ActionController {
	
	public $params;
	private $RenderView = true;
	public $redirection = false;
	
	public function __construct($options) { 
		$this->params 					= $options['params'];
		$this->params['controller'] 	= $options['controller'];
		$this->params['action'] 		= $options['action'];
		
		$this->callbacks();
	}
	
	public function render($val, $header=null) {
		if($val === false) {
			$this->RenderView = false;
		} else {
			$this->RenderView = array($val, $header);
		}
	}
	
	public function redirect($url) {
		$this->redirection = true;
		header("Location: $url");
	}
	
	public function getRender() {
		return ($this->RenderView);
	}
	
	private function callbacks() {
		# Before Filter.
		if(method_exists($this, 'before_filter')) $this->before_filter();
		
		
	}
	
	
}
?>