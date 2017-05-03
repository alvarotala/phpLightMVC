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
		
		ini_set('SMTP', SMTP_HOST);
		ini_set('smtp_port', SMTP_PORT);
		
		$subject = utf8_decode($subject);
		
		@mail($to, $subject, $message, $header);
	}
}