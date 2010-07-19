<?
# place to common stuff's...

class ApplicationController extends ActionController { 
	
	protected function check_something() {
		# do some incredible stuff...
		$this->something_happen = true;
	}
	
	protected function logged() {
		if(true) {
			HTTP::redirect(WWW_PATH . '/');
		}
	}

}
?>