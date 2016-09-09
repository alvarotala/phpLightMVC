<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class Sendmail
 */

class Sendmail {

	static public function sendWithPHPMail($to, $from, $name, $subject='test', $message='test') {
		$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=utf8' . "\r\n";
		$header .= "From: {$name} <{$from}>" . "\r\n";
		
		ini_set('SMTP', "relay-hosting.secureserver.net");
		ini_set('smtp_port', "25");
		
		
		$subject = utf8_decode($subject);
		
		@mail($to, $subject, $message, $header);
	}
	
	static public function sendWithPolkaSMTP($to, $from, $subject='test', $message='test') {
		$smtp = new Smtp("mail.polka.cc", 25, 'tls');
		$smtp->auth('no-reply@polka.cc', 'polka');		
		$smtp->send($to, $subject, $message, $from);		
	}
}


class SMTP {
	
	/**
	 * Connection resource
	 * 
	 * @access private
	 * @var resource
	 */
	private $connection;
	
	/**
	 * Connection timeout
	 * 
	 * @access public
	 * @var int
	 */
	public $timeout = 30;
	
	/**
	 * Set if debug mode or not
	 * 
	 * @access public
	 * @var bool 
	 */
	public $debug = false;
	
	/**
	 * SMTP Host
	 * 
	 * @access public
	 * @var string
	 */
	public $host;
	
	/**
	 * Port number
	 * 
	 * @access public
	 * @var int
	 */
	public $port; 
	
	/**
	 * Username
	 * 
	 * @access public
	 * @var string
	 */
	public $username;
	
	/**
	 * Password
	 * 
	 * @access public
	 * @var string
	 */
	public $password;
	
	/**
	 * Security type
	 * none | tls | ssl
	 * 
	 * @access public
	 * @var string 
	 */
	public $secure;
	
	/**
	 * Requires authentication or not
	 *
	 * @access public
	 * @var bool
	 */
	public $auth = true;
	
	/**
	 * Charset
	 *
	 * @access public
	 * @var string
	 */
	public $charset = 'UTF-8';
	
	/**
	 * Encoding
	 *
	 * @access public
	 * @var string
	 */
	public $encoding = '7bit';
	
	/**
	 * Debugging logs
	 * 
	 * @access private
	 * @var array
	 */
	private $logs = array();
	
	/**
	 * Error no
	 * 
	 * @access private
	 * @var int
	 */
	private $errorNo = 0;
	
	/**
	 * Error Message
	 * 
	 * @access private
	 * @var string
	 */
	private $errorMessage = '';
	
	/**
	 * New line
	 * @var string
	 */
	const CRLF = "\r\n";
	
	/**
	 * Constructor function
	 * 
	 * @access	public
	 * 
	 * @param	string	$host
	 * @param	int		$port
	 * @param	string	$secure		none | tls | ssl
	 */
	public function __construct($host = null, $port=25, $secure='none')
	{
		$this->log('SMTP class initialized');
		
		if( $host != null )
			$this->connect($host, $port, $secure);
	}
	
	/**
	 * Connects to smtp host
	 * 
	 * @return SMTP
	 */
	public function connect($host, $port=25, $secure='none')
	{
		$this->host 	= $host;
		$this->port		= $port;
		$this->secure	= $secure;
		
		$this->log('Trying to connect host');
		
		if( $this->secure == 'ssl' ) {
			$host = 'ssl://' . $this->host;
		} else {
			$host = $this->host;
		}
		
		$this->connection = fsockopen($host, $this->port, $this->errorNo, $this->errorMessage, $this->timeout);
		
		if(!$this->connection) {
			$this->log('Unable to connect host : '. $this->host);
			return $this;
		} else {
			$this->log('Connection successful');
		}
		
		// Gets greeting
		$this->get();
		
		// Ehlo package
		$this->put('EHLO '.$this->host );
		
		if ($this->secure == 'tls') {
			$this->put('STARTTLS');
			
			stream_socket_enable_crypto($this->connection, TRUE, STREAM_CRYPTO_METHOD_TLS_CLIENT);
			
			$this->put('EHLO '.$this->host );
		}
		
		return $this;
	}
	
	/**
	 * Login to server
	 * @param string $username
	 * @param string $password
	 */
	public function auth($username = null, $password = null)
	{
		$this->username = $username;
		$this->password = $password;
		
		$this->put( 'AUTH LOGIN' );
		// Sends username
		$this->put( base64_encode($this->username) );
		
		// Sends password
		$this->put( base64_encode($this->password) );
	}
	
	/**
	 * Send e-mail
	 * @param string $to
	 * @param string $subject
	 * @param string $body
	 */
	function send($to, $subject, $body, $from = null)
	{
		if( !$from ) {
			$from = $this->username;
		}
		
		$boundary = md5(uniqid(time()));
		
		// Sent mail from
		$this->put('MAIL FROM:<'.$from.'>');
		
		// Sent to
		$this->put('RCPT TO:<'.$to.'>');
		
		$this->put('DATA');
				
		$headers = array(
			'MIME-Version: 1.0',
			'Content-type: text/html; charset='. $this->charset,
			'TO:<'. $to .'>',
			'FROM:<'. $from .'>',
			'SUBJECT:'. $subject .''. self::CRLF . self::CRLF,
			$body . self::CRLF . '.'  . self::CRLF
		);
		
		$data = implode(self::CRLF, $headers);
		
		$this->put($data);
		
		$this->put('QUIT');
	}
	
	/**
	 * Puts data to socket
	 * 
	 * @param	string $data
	 * @return	SMTP
	 */
	public function put($data, $crlfCount = 1)
	{
		$crlf = '';
		for( $i = 0; $i<$crlfCount; $i++ )
			$crlf .= self::CRLF;
		
		$this->log('Puts data: '. $data);
		
		fputs($this->connection, $data . $crlf);
		
		// Gets response
		$this->get();
	}
	
	/**
	 * Reads data from socket
	 * 
	 * @param	int	 $length
	 * @return	SMTP
	 */
	public function get($length = 1024)
	{
		$response = '';
		while ($str = fgets($this->connection, $length))
		{
			$response .= $str;
			if (substr($str, 3, 1) === ' ') break;
		}
		
		$this->log('Gets data: '. $response);
		
		return $response;
	}
	
	/**
	 * Closes connection
	 * 
	 * @access public
	 * @return SMTP
	 */
	public function close()
	{
		$this->log('Closing connection');
		
		fclose($this->connection);
		
		return $this;
	}
	
	/**
	 * Gets logs
	 * 
	 * @access public
	 * 
	 * @return array
	 */
	public function getLogs()
	{
		return $this->logs;
	}
	
	/**
	 * Gets error
	 * @return multitype:number string
	 */
	public function getError()
	{
		return array(
			'code' => $this->errorNo,
			'message' => $this->errorMessage
		);
	}
	
	/**
	 * Sets debug mode
	 *
	 * @access	public
	 * @param	bool	$mode
	 */
	public function debug($mode)
	{
		$this->debug = $mode;
	}
	
	/**
	 * Logs message for debugging
	 * 
	 * @access private
	 * @param string $message
	 */
	private function log($message)
	{
		if( $this->debug == true ) {
			echo "<code>$message</code><br />";
		}
			
		$this->logs[] = array(
			'time' => time(),
			'message' => $message
		);
	}
	
	
	public function __destruct()
	{
		$this->close();
	}
}

?>
