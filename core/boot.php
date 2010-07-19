<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 */

session_start();

define('DS', 				DIRECTORY_SEPARATOR);

# Rutas del Sitio
define('ROOT_PATH'			, realpath(dirname(__FILE__)) . '/..'); # raiz de la aplicacion
define('CORE_PATH'			, ROOT_PATH . '/core'); # raiz de core
define('APP_PATH'			, ROOT_PATH . '/app');
define('PUBLIC_PATH'		, ROOT_PATH . '/public');


require_once CORE_PATH . '/config.php';
require_once CORE_PATH . '/libs/class.base.php';

Base::autoload();
?>
