<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class FileLogger
 */

# define('LOGGING_DIR', '/var/log/app'); # Directorio del log

class FileLogger {
	var $DEBUG   = 'DEBUG';
	var $INFO    = 'INFO';
	var $WARN	 = 'WARN';
	var $ERROR   = 'ERROR';
	
	var $_instance = null;
	var $_enabled;
	var $_logDir;
	var $_level;
	
	function FileLogger() {
		//Logging dir
		$this->_logDir = defined('LOGGING_DIR') ? LOGGING_DIR : './log';
		
		//Logging enabled
		$this->_enabled = defined('LOGGING_ENABLED') && LOGGING_ENABLED;
		
		//Logging level
		$this->_level = defined('LOGGING_LEVEL') ? strtoupper(LOGGING_LEVEL) : $this->DEBUG;
	}
	
	function getInstance() {
		if($this->_instance === null) {
			$this->_instance= new FileLogger();
		}
		return $this->_instance;
	}
	
	function logToFile($msg, $level) {
		//Is enabled?
		if(!$this->_enabled) return;
		
		//Logging level filter
		switch($this->_level) {
			case $this->DEBUG:
				if(!($level === $this->DEBUG || $level === $this->INFO || $level === $this->WARN || $level === $this->ERROR)) {
					return;
				}
			break;
			
			case $this->INFO:
				if(!($level === $this->INFO || $level === $this->WARN || $level === $this->ERROR)) {
					return;
				}
			break;
			
			case $this->WARN:
				if(!($level === $this->WARN || $level === $this->ERROR)) {
					return;
				}
			break;
			
			case $this->ERROR:
				if(!($level === $this->ERROR)) {
					return;
				}
			break;
			
			default:
			return;
		}
		
		$file = "log_" . date("Ymd", mktime()) . ".log";
		if($this->_logDir) {
			$file = $this->_logDir."/".$file;
		}
		
		// open file
		$fd = fopen($file, "a");
		if(!$fd) return;
		
		$str = "  [4;36;1m(".date("Y/m/d H:i:s", mktime()).")[0m  [4;35;1m(".$level.")[0m ".$msg; 
		
		// write string
		fwrite($fd, $str . "\n");
		
		// close file
		fclose($fd);
	}
		
	function debug($msg) {
		$this->logToFile($msg, $this->DEBUG);
	}
	
	function info($msg) {
		$this->logToFile($msg, $this->INFO);
	}
	
	function warning($msg) {
		$this->logToFile($msg, $this->WARN);
	}
	
	function error($msg) {
		$this->logToFile($msg, $this->ERROR);
	}
	
}
?>
