<?
# place to common stuff's...

class ApplicationController extends ActionController { 
	
	protected function before_filter() {
		// executed on all request.
	}
	
	protected function check_something() {
		# do some incredible stuff...
		$this->something_happen = true;
	}
	
	protected function logged() {
		if(true) {
			$this->redirect(WWW_PATH . '/');
		}
	}

}
?>