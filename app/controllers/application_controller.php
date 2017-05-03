<?
# place to common stuff's...

class ApplicationController extends ActionController { 
	
	protected function before_filter() {
		// executed on all request.
	}
	
	public function ajax($status, $data="") {
		# header("Content-Type: application/gzip");
		# header("Content-Encoding: gzip");
		# header("Accepts-Encoding: gzip");
		$this->render(json_encode(array('status' => $status, 'data' => $data)), 'text/plain');
	}
	
	protected function notice($message) {
		Flash::notice($message);
	}
	
	protected function error($message) {
		Flash::error($message);
	}
	
	
	## EXAMPLES ##
	
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