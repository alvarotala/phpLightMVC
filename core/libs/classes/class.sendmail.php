<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class Sendmail
 */

/***

	define('SMPP_HOST'	, 'mail.cominio.com');
	define('SMPP_USER'	, 'user');
	define('SMPP_PASS'	, 'pass');
	define('SMPP_NAME'	, 'name');
	define('SMPP_FROM'	, 'from');
	
	Options:
		+ 'body'	=> 'el cuerpo del mail'
		+ 'to'		=> 'el destinatario del mail'
		+ 'subject'	=> 'el asunto del mail'
		+ 'from'	=> 'el remitente del mail, en caso de tener esta opcion, sobrescribe la definida en SMPP_FROM'
		+ 'name'	=> 'el nombre del remitente del mail, en caso de tener esta opcion, sobrescribe la definida en SMPP_NAME'
		+ 'attach'	=> 'archivos adjuntos'
		
	Example:
	
	Sendmail::send(array(
					'body' 		=> 'Hola mundo',
					'to' 			=> 'email@gmail.com',
					'subject' 	=> 'asunto',				
					'from' 		=> 'remitente@gmail.com',
					'name' 		=> 'Remitente',
					'attach'		=> array(array('files/demo.zip', 'name.zip'),
										 		array('files/image.jpg')
										)					
	));

***/

class Sendmail {

	function send($options = array()) {
		$mail = new PHPMailer();
		
		$mail->IsSMTP();
		$mail->Host 		= empty($options['host']) ? SMPP_HOST : $options['host'];
		$mail->SMTPAuth 	= true;
		$mail->Port 		= 25;
		$mail->Username 	= empty($options['user']) ? SMPP_USER : $options['user'];
		$mail->Password 	= empty($options['pass']) ? SMPP_PASS : $options['pass'];
		$mail->From 		= empty($options['from']) ? SMPP_FROM : $options['from'];
		$mail->FromName 	= empty($options['name']) ? SMPP_NAME : $options['name'];
		$mail->Subject 	= $options['subject'];
		$mail->IsHTML(true);
		$mail->AddAddress($options['to']);

		if (isset($options['cc'])) {
			foreach ($options['cc'] as $i => $email) {
				$mail->AddCC($email);	
			}			
		} 
		
		if (isset($options['attach'])) {
			foreach ($options['attach'] as $i => $file) {
				if ($file[1]) {
					$mail->AddAttachment($file[0], $file[1]);		
				} else {
					$mail->AddAttachment($file[0]);		
				}
			}
		}

		$mail->Body = $options['body'];
		if (!$mail->Send()) {
			echo "<pre>[ERROR] Can't send email: ".$options['to']."\n\n Error: ".$mail->ErrorInfo."</pre>";
			return false;
		} else {
			return true;
		}      
	}	
}


?>
