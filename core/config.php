<?
ini_set('display_errors', 1);
ini_set("session.gc_maxlifetime","3600");

error_reporting(E_ALL ^E_NOTICE ^E_WARNING ^E_DEPRECATED);

date_default_timezone_set('UTC');

# Datos del Sitio

define('DOMAIN'				, 'localhost');
define('SITE_NAME'			, 'PhpLightMVC example');
define('WWW_PATH'			, 'http://' . DOMAIN . '/projects/phpLightMVC.com/src/phpLightMVC/public');		# public root path


# DB Mysql
define('MY_DB_USER'			, 'root');	 					# User
define('MY_DB_PASS'			, ''); 							# Password
define('MY_DB_SERVER'		, '127.0.0.1'); 				# Host
define('MY_DB_NAME'			, 'test');						# Db name

# Email
define('SMPP_HOST'			, 'smtp.host.com');
define('SMPP_USER'			, 'username');
define('SMPP_PASS'			, 'password');
define('SMPP_FROM'			, 'example@host.com');
define('SMPP_NAME'			, 'From Name');


# Security Vault
define('SECURITY_VAULT'		, '__ajnadj89JHLKJN*&&@*)LN)(PJILKNkj&&*&*%%KKK??+==_UHJKL@u98230jnsd');

# Session
define('_SESSION_NAME'		, (md5(SECURITY_VAULT). '___session_name_'));

?>
