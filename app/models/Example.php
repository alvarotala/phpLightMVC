<?
/**
 * For a more in-depth look at defining models, relationships, callbacks and many other things
 * please consult {@link http://www.phpactiverecord.org/guides Guides}. Or checkout the active_record
 * folder inside the core/libs/classes folder of this project. 
 */

class Example extends ActiveRecord\Model {
	
	static $table_name = 'example_table'; # name of table
	
	
	# Example of sendmail with html body
	public function send_mail() {
		$tmpl = Template::mail('example.php');
		$tmpl->replace(array(
			'name' => 'John Smith'
		));
	
		Sendmail::send(array(
			'to' 		=> 'john@example.com',
			'subject' 	=> 'Hello new user!',
			'body'		=> 	$tmpl->render()
		));
	}
	
}

?>