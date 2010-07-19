<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class ActionController
 */

class ActionController {
	
	public $params;
	private $RenderView = true;
	
	public function __construct($params) { 
		$this->params = $params;
		$this->callbacks();
	}
	
	public function render($val, $header=null) {
		if($val === false) {
			$this->RenderView = false;
		} else {
			$this->RenderView = array($val, $header);
		}
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