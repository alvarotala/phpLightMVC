<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class HTTP
 */

class HTTP {
	
	static function URL($params) {
		if(REWRITE !== true) {
			return WWW_PATH . '/?url=' . $params;
		} else {
			return $params;
		}
	}
	
	
	static function arrayToQueryString($data) {
		$str="";
		foreach($data as $k => $v) {
			$str = $str . '&' . $k . '=' . $v; 
		}
		
		$str = substr($str, 1, strlen($str));
		$str = urlencode($str);
		return $str;
	}
	
	/* Lista de paices */
	static function paises() {
		return(array('Paraguay',
  		'Afganistán', 
		'Albania', 
		'Alemania', 
		'Andorra', 
		'Angola', 
		'Anguilla', 
		'Antigua y Barbuda', 
		'Antillas holandesas', 
		'Arabia Saudí', 
		'Argelia', 
		'Argentina', 
		'Armenia', 
		'Australia', 
		'Austria', 
		'Azerbayán', 
		'Bahamas', 
		'Bahréin', 
		'Bangladesh', 
		'Barbados', 
		'Bélgica', 
		'Belice', 
		'Benin', 
		'Bermudas', 
		'Bielorrusia', 
		'Bolivia', 
		'Bosnia y Hercegovina', 
		'Botswana', 
		'Brasil', 
		'Brunei Darussalam', 
		'Bulgaria', 
		'Burkina Faso', 
		'Burundi', 
		'Bután', 
		'Cabo Verde', 
		'Camboya', 
		'Camerún', 
		'Canadá', 
		'Chad', 
		'Chile', 
		'China', 
		'Chipre', 
		'Colombia', 
		'Comoras', 
		'Congo', 
		'Corea (República de)', 
		'Corea (República Popular de)', 
		'Costa de Marfil', 
		'Costa Rica', 
		'Croacia', 
		'Cuba', 
		'Dinamarca', 
		'Dominica', 
		'Ecuador', 
		'Egipto', 
		'El Salvador', 
		'Emiratos Árabes Unidos', 
		'Eritrea', 
		'Eslovaquia', 
		'Eslovenia', 
		'España', 
		'Estados federales de Micronesia', 
		'Estados Unidos', 
		'Estonia', 
		'Etiopía', 
		'Federación rusa', 
		'Fiji', 
		'Filipinas', 
		'Finlandia', 
		'Francia', 
		'Gabón', 
		'Gambia', 
		'Georgia', 
		'Georgia del Sur', 
		'Ghana', 
		'Gibraltar', 
		'Granada', 
		'Grecia', 
		'Groenlandia', 
		'Guadalupe', 
		'Guam', 
		'Guatemala', 
		'Guayana Francesa', 
		'Guinea', 
		'Guinea Bissau', 
		'Guinea Ecuatorial', 
		'Guyana', 
		'Haití', 
		'Honduras', 
		'Hong Kong', 
		'Hungría', 
		'India', 
		'Indonesia', 
		'Irán', 
		'Iraq', 
		'Irlanda', 
		'Isla Ascensión', 
		'Isla de Man', 
		'Islandia', 
		'Isla Norfolk', 
		'Islas Caimán', 
		'Islas Cook', 
		'Islas Feroe', 
		'Islas Malvinas', 
		'Islas Marianas del Norte', 
		'Islas Marshall', 
		'Islas Salomón', 
		'Islas Turks y Caicos', 
		'Islas Vírgenes (EE. UU.)', 
		'Islas Vírgenes (Reino Unido)', 
		'Islas Wallis y Futuna', 
		'Israel', 
		'Italia', 
		'Jamaica', 
		'Japón', 
		'Jordano', 
		'Kazajstán', 
		'Kenia', 
		'Kiribati', 
		'Kuwait', 
		'Kyrguizistán', 
		'Laos', 
		'Lesoto', 
		'Letonia', 
		'Líbano', 
		'Liberia', 
		'Libia', 
		'Liechtenstein', 
		'Lituania', 
		'Luxemburgo', 
		'Macau', 
		'Macedonia', 
		'Madagascar', 
		'Malasia', 
		'Malawi', 
		'Maldivas', 
		'Mali', 
		'Malta', 
		'Marruecos', 
		'Martinica', 
		'Mauricio', 
		'Mayotte', 
		'México', 
		'Moldavia', 
		'Mónaco', 
		'Mongolia', 
		'Montenegro', 
		'Montserrat', 
		'Mozambique', 
		'Myanmar', 
		'Namibia', 
		'Nauru', 
		'Nepal', 
		'Nicaragua', 
		'Níger', 
		'Nigeria', 
		'Niue', 
		'Noruega', 
		'Nueva Caledonia', 
		'Nueva Zelanda', 
		'Omán', 
		'Países Bajos', 
		'Palau', 
		'Panamá', 
		'Papúa Nueva Guinea', 
		'Paquistán', 
		'Perú', 
		'Pitcairn', 
		'Polinesia Francesa', 
		'Polonia', 
		'Portugal', 
		'Puerto Rico', 
		'Qatar', 
		'Reino Unido', 
		'República Árabe Siria', 
		'República Centroafricana', 
		'República Checa', 
		'República Democrática del Congo', 
		'República Dominicana', 
		'Reunión', 
		'Ruanda', 
		'Rumanía', 
		'Samoa Americana', 
		'Samoa Occidental', 
		'San Cristóbal y Nevis', 
		'San Marino', 
		'San Pedro y Miguelón', 
		'Santa Lucía', 
		'Santo Tomé y Príncipe', 
		'San Vicente y las Granadinas', 
		'Senegal', 
		'Serbia', 
		'Seychelles', 
		'Sierra Leona', 
		'Singapur', 
		'Somalia', 
		'Sri Lanka', 
		'Suazilandia', 
		'Sudáfrica', 
		'Sudán', 
		'Suecia', 
		'Suiza', 
		'Surinam', 
		'Tailandia', 
		'Taiwán', 
		'Tanzania', 
		'Tayikistán', 
		'Territorio Británico del Océano Índico', 
		'Togo', 
		'Tokelau', 
		'Tonga', 
		'Trinidad y Tobago', 
		'Túnez', 
		'Turkmenistán', 
		'Turquía', 
		'Tuvalu', 
		'Ucrania', 
		'Uganda', 
		'Uruguay', 
		'Uzbekistán', 
		'Vanuatu', 
		'Venezuela', 
		'Vietnam', 
		'Yemen', 
		'Yibuti', 
		'Yugoslavia', 
		'Zambia', 
		'Zimbabue'));
	}
	
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

	static function months($m) {
		$months = array(null, 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		return $months[$m];
	}
	

	static function redirect($url) {
		header("Location: $url");
	}
	
	static function set_flash($kind, $message) {
		Session::array_set('flash', $kind, $message);
	}
		
	static function flash($kind) {
		$flash = Session::array_get('flash');
		$flash = $flash[$kind];
		if(isset($flash) && !empty($flash)) {
			Session::destroy('flash');
			return $flash;
		}
	}
	
	static function Notifications() {
		$message = self::flash('notice');
		if(!empty($message)) {
			echo "<div style=\"border:1px solid green; background: #a4ffb9; padding: 10px; color: green;\">{$message}</div>";
		}
		
		$message = self::flash('error');
		if(!empty($message)) {
			echo "<div style=\"border:1px solid red; background: #ffc9c9; padding: 10px; color: red;\">{$message}</div>";
		}
	}
}

?>
