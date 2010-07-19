<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class Base
 */

require_once(CORE_PATH . '/libs/classes/class.session.php');
require_once(CORE_PATH . '/libs/classes/class.json.php');
require_once(CORE_PATH . '/libs/classes/phpmailer/class.phpmailer.php');
require_once(CORE_PATH . '/libs/classes/phpmailer/class.smtp.php');
require_once(CORE_PATH . '/libs/classes/class.sendmail.php');
require_once(CORE_PATH . '/libs/classes/class.folder.php');
require_once(CORE_PATH . '/libs/classes/class.file_logger.php');
require_once(CORE_PATH . '/libs/classes/class.object.php');
require_once(CORE_PATH . '/libs/classes/class.string.php');
require_once(CORE_PATH . '/libs/classes/class.template.php');
require_once(CORE_PATH . '/libs/classes/class.http.php');
require_once(CORE_PATH . '/libs/classes/active_record/ActiveRecord.php');

require_once CORE_PATH . '/libs/framework/class.router.php';
require_once CORE_PATH . '/libs/framework/class.dispatcher.php';
require_once CORE_PATH . '/libs/framework/class.action_controller.php';
require_once CORE_PATH . '/libs/framework/class.action_view.php';

require_once CORE_PATH . '/libs/extras/class.extras.php';

class Base {
	
	public static function autoload() {
		$connections = array(
			'development' => 'mysql://'.MY_DB_USER.':'.MY_DB_PASS.'@'.MY_DB_SERVER.'/'.MY_DB_NAME
		);

		// initialize ActiveRecord
		ActiveRecord\Config::initialize(function($cfg) use ($connections)
		{
		    $cfg->set_model_directory(APP_PATH . '/models');
		    $cfg->set_connections($connections);
		});
		
		Folder::require_folders(APP_PATH . '/controllers/');
	}
}

?>
