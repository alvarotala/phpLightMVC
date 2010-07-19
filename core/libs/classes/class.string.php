<?
/**
 * Tiene todas las funciones staticas para el procesamiento de cadenas
 *
 * @package String
 * @author Miguel Godoy
 **/
class String
{
	/**
	 * Funcion que convierte los espacios en guion bajo y pasa todos los caracteres en minusculas
	 * 
	 * Ejemplo:
	 * <code>
	 * $cadena = String::('HolaMundo'); // Devuelve 'hola_mundo'
	 * </code>
	 *
	 * @return string Devuelve la cadena procesada
	 * @author Miguelati
	 * @access public
	 **/
	public static function underscore($string) {
		return strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $string));
	}
	/**
	 * Funcion que convierte los guiones bajo en espacios.
	 *
	 * @return string Devuelve la cadena procesado
	 * @author Miguelati
	 * @access public
	 **/
	public static function humanize($lowerCaseAndUnderscoredWord) {
		return ucwords(str_replace("_", " ", $lowerCaseAndUnderscoredWord));
	}
	
	/**
	 * Funcion que de underscore a camel.
	 *
	 * @return string Devuelve la cadena procesado
	 * @author Miguelati
	 * @access public
	 **/
	public static function camelize($lowerCaseAndUnderscoredWord) {
		return ucwords(str_replace("_", "", $lowerCaseAndUnderscoredWord));
	}
	
	
	/**
	 * Devuelve un print_r dentro del tags <pre>
	 *
	 * @return void
	 * @author Miguelati
	 * @access public
	 **/
	public static function pr($var){
		echo "<pre>";
		print_r($var);
		echo "</pre>";
	}

	public static function upper($string){
		return strtoupper($string);
	}
	
	public static function lower($string){
		return strtolower($string);
	}
	
	public static function truncate($string, $to){
		$posicion = strpos($string, $to);
		if ($posicion !== false) {
			return substr($string, 0, $posicion + 1);
		} else {
			return false;
		}
	}
} // END class 

?>