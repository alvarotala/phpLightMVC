<?
class Crypto {
	
	static function md5($str) {
		return(md5($str . SECURITY_VAULT));
	}

	static function random_str($len) {
  		$chars = "abcdefghijkmnopqrstuvwxyz023456789@!-_..=+$%*&#"; 
		    srand((double)microtime()*1000000); 
		    $i = 0; 
		    $pass = '' ; 

		    while ($i <= $len) { 
		        $num = rand() % 33; 
		        $tmp = substr($chars, $num, 1); 
		        $pass = $pass . $tmp; 
		        $i++; 
		    } 

		    return $pass;
	}
	
}
?>