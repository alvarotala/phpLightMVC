<?

class ExampleController extends ApplicationController {

	# This is a callback.. It's run in every request before the actual action it's called.
	protected function before_filter() {
		parent::before_filter();
		
		$this->check_something(); # controlo que este logueado para ingresar.

		switch($this->params['action']) {
			case 'index':
			case 'show':
				// do something
			break;
			
			case 'test':
				// do other stuff..
			break;
		}
	}
	
	# /example/index
	function index() {
		$this->a_variable_name = "Hello World";
	}
	
	# /example/show
	function show() {	
		$this->message = "The user ID is: {$this->params['get']['id']}";
	}
	
	# /login
	# /example/login
	function login() {
		$this->logged(); # getted from super class (ApplicationController).
	}
	
	# /example/logout
	function messages() {
		Flash::notice("Success message.");
		Flash::error("Error message.");
		
		$this->redirect(WWW_PATH . '/');
	}
	
	# /example/test (with mod_rewrite)
	# /?url=/example/test (without mod_rewrite)
	function test() {
		# do somethig..
		
		# when render is setted in false, the framework will not respond with a view.
		# in other words, there is no need of create a view file when an action render false..
		$this->render(false);
	}
	
	# /example/test2 (with mod_rewrite)
	# /?url=/example/test2 (without mod_rewrite)
	function test2() {
		# do somethig..
		
		# when string is passed to render, this will be the output, ignored a view file if exists.
		$this->render("Hello!");
		
		# optionaly, you can set the header
		# $this->render("Hello!", "text/plain");
		# $this->render(file_get_contents($an_image), "image/jpg");
	}
	
}
?>