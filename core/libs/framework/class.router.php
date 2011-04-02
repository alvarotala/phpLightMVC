<?
/**
 * @author Alvaro Talavera (alvarotala@gmail.com)
 * @class Router
 */

if(!defined('OPTIONAL')){
    define('OPTIONAL', false);
}

if(!defined('COMPULSORY')){
    define('COMPULSORY', true);
}

if(!defined('COMPULSORY_REGEX')){
    define('COMPULSORY_REGEX', '([^\/]+){1}');
}

class Router {
	
	public static function load() {
		$map = new self();
		require_once CORE_PATH . '/routes.php';
		
		return $map;
	}
	
	
	private $maps = array();
	
	private $reserved_keys = array('controller', 'action');
	
	function __construct() { 
		
	}
	
	public function connect($url, $options=array(), $requirements = null) {
		# array_push($this->maps, $this->maps_to_array($url, $options));
		
		$this->_mapRoutes($url, $options, $requirements);
		# String::pr($this->maps);
	}
	
	public function apply($full_url) {
		$url = $this->_getParsedUrl($full_url);
				
		$mapped_path = $this->_toParams($url['path']);
		
		foreach($mapped_path as  $k => $v) {
			if(!in_array($k, $this->reserved_keys)) {
				$url['query']['get'][$k] = $v;
			}
		}
		
		if(empty($mapped_path['action'])) $mapped_path['action'] = 'index';
		
		$mapped_url = array(
			'controller' => $mapped_path['controller'], 
			'action' => $mapped_path['action'], 
			'params' => $url['query']
		);
		
		return $mapped_url;
	}
	
	
	/**
	* This fragment was extracted from Akelos Framework (http://www.akelos.org/)
	*
    * Add a rewrite rule
    *
    * Rewrite rules are defined on the file <code>config/routes.php</code>
    *
    * Rules that are defined first take precedence over the rest.
    *
    * @access public
    * @param    string    $url_pattern    URL patterns have the following format:
    *
    * - <b>/static_text</b>
    * - <b>/:variable</b>  (will load $variable)
    * - <b>/*array</b> (will load $array as an array)
    * @param    array    $options    Options is an array with and array pair of field=>value
    * The following example <code>array('controller' => 'page')</code> sets var 'controler' to 'page' if no 'controller' is specified in the $url_pattern param this value will be used.
    *
    * The following constants can be used as values:
    * <code>
    * OPTIONAL // 'var_name'=> OPTIONAL, will set 'var_name' as an option
    * COMPULSORY // 'var_name'=> COMPULSORY, will require 'var_name' to be set
    * </code>
    * @param    array    $requirements    $requirements holds an array with and array pair of field=>value where value is a perl compatible regular expression that will be used to validate rewrite rules
    * The following example <code>array('id'=>'/\d+/')</code> will require that var 'id' must be a numeric field.
    *
    * NOTE:If option <b>'id'=>OPTIONAL</b> this requirement will be used in case 'id' is set to something
    * @return void
    */
	
	private function _mapRoutes($url_pattern, $options = array(), $requirements = null) {
		
        if(!empty($options['requirements'])){
            $requirements = empty($requirements) ? $options['requirements'] : array_merge($options['requirements'],$requirements);
            unset($options['requirements']);
        }

        preg_match_all('/(([^\/]){1}(\/\/)?){1,}/',$url_pattern,$found);
        $url_pieces = $found[0];

        $regex_arr = array();
        $optional_pieces = array();
        $var_params = array();
        $arr_params = array();
        foreach ($url_pieces as $piece){
            $is_var = $piece[0] == ':';
            $is_arr = $piece[0] == '*';
            $is_constant = !$is_var && !$is_arr;

            $piece = $is_constant ? $piece : substr($piece,1);

            if($is_var && !isset($options[$piece])){
                $options[$piece] = OPTIONAL;
            }

            if($is_arr && !isset($options[$piece])){
                $options[$piece] = OPTIONAL;
            }

            if(($is_arr || $is_var) && $piece == 'this'){
                trigger_error('You can\'t use the reserved word this for mapping URLs', E_USER_ERROR);
            }

            //COMPULSORY

            if($is_constant){
                $regex_arr[] = array('_constant_'.$piece => '('.$piece.'(?=(\/|$))){1}');
            }elseif(isset($requirements[$piece])){
                if (isset($options[$piece]) && $options[$piece] !== COMPULSORY){
                    $regex_arr[] = array($piece=> '(('.trim($requirements[$piece],'/').'){1})?');
                }elseif(isset($options[$piece]) && $options[$piece] !== OPTIONAL){
                    $regex_arr[] = array($piece=> '(('.trim($requirements[$piece],'/').'){1}|('.$options[$piece].'){1}){1}');
                }else{
                    $regex_arr[] = array($piece=> '('.trim($requirements[$piece],'/').'){1}');
                }
            }elseif(isset($options[$piece])){
                if($options[$piece] === OPTIONAL){
                    $regex_arr[] = array($piece=>'[^\/]*');
                }elseif ($options[$piece] === COMPULSORY){
                    $regex_arr[] = array($piece=> COMPULSORY_REGEX);
                }elseif(is_string($options[$piece]) && $options[$piece][0] == '/' &&
                ($_tmp_close_char = strlen($options[$piece])-1 || $options[$piece][$_tmp_close_char] == '/')){
                    $regex_arr[] = array($piece=> substr($options[$piece],1,$_tmp_close_char*-1));
                }elseif ($options[$piece] != ''){
                    $regex_arr[] = array($piece=>'[^\/]*');
                    $optional_pieces[$piece] = $piece;
                }
            }else{
                $regex_arr[] = array($piece => $piece);
            }


            if($is_var){
                $var_params[] = $piece;
            }
            if($is_arr){
                $arr_params[] = $piece;
            }

            if(isset($options[$piece]) && $options[$piece] === OPTIONAL){
                $optional_pieces[$piece] = $piece;
            }
        }

        foreach (array_reverse($regex_arr) as $pos=>$single_regex_arr){
            $var_name = key($single_regex_arr);
            if((isset($options[$var_name]) && $options[$var_name] === COMPULSORY) || (isset($requirements[$var_name]) && $requirements[$var_name] === COMPULSORY)){
                $last_optional_var = $pos;
                break;
            }
        }

        $regex = '/^((\/)?';
        $pieces_count = count($regex_arr);

        foreach ($regex_arr as $pos=>$single_regex_arr){
            $k = key($single_regex_arr);
            $single_regex = $single_regex_arr[$k];

            $slash_delimiter = isset($last_optional_var) && ($last_optional_var <= $pos) ? '{1}' : '?';

            if(isset($optional_pieces[$k])){
                $terminal = (is_numeric($options[$k]) && $options[$k] > 0 && in_array($k,$arr_params)) ? '{'.$options[$k].'}' : ($pieces_count == $pos+1 ? '?' : '{1}');
                $regex .= $is_arr ? '('.$single_regex.'\/'.$slash_delimiter.')+' : '('.$single_regex.'\/'.$slash_delimiter.')'.$terminal;
            }else{
                $regex .= $is_arr ? $single_regex.'\/+' : $single_regex.'\/'.($pieces_count == $pos+1 ? '?' : $slash_delimiter);
            }
        }
        $regex = rtrim($regex ,'/').'){1}$/';
        $regex = str_replace('/^\$/','/^\\/?$/',$regex);


        $this->maps[] = array(
        'url_path' => $url_pattern,
        'options' => $options,
        'requirements' => $requirements,
        'url_pieces' => $url_pieces,
        'regex' => $regex,
        'regex_array' => $regex_arr,
        'optional_params' => $optional_pieces,
        'var_params' => $var_params,
        'arr_params' => $arr_params
        );
    }
	
    private function _toParams($url) {
		$url = $url == '/' || $url == '' ? '/' : '/'.trim($url,'/').'/';
        $nurl = $url;

        foreach ($this->maps as $_route){
            $params = array();

            if(preg_match($_route['regex'], $url)){
                foreach ($_route['regex_array'] as $single_regex_arr){

                    $k = key($single_regex_arr);

                    $single_regex = $single_regex_arr[$k];
                    $single_regex = '/^(\/'.$single_regex.'){1}/';
                    preg_match($single_regex, $url, $got);

                    if(in_array($k,$_route['arr_params'])){
                        $url_parts = strstr(trim($url,'/'),'/') ? explode('/',trim($url,'/')) : array(trim($url,'/'));

                        $pieces = (isset($_route['options'][$k]) && $_route['options'][$k] > 0) ? $_route['options'][$k] : count($url_parts);
                        while ($pieces>0) {
                            $pieces--;
                            $url_part = array_shift($url_parts);
                            $url = substr_replace($url,'',1,strlen($url_part)+1);

                            if(preg_match($single_regex, '/'.$url_part)){
                                $params[$k][] = $url_part;
                            }
                        }
                    }elseif(!empty($got[0])){
                        $url = substr_replace($url,'',1,strlen($got[0]));
                        if(in_array($k,$_route['var_params'] )){
                            $param = trim($got[0],'/');
                            $params[$k] = $param;
                        }
                    }
                    if(isset($_route['options'][$k])){

                        if($_route['options'][$k] !== COMPULSORY &&
                        $_route['options'][$k] !== OPTIONAL &&
                        $_route['options'][$k] != '' &&
                        ((!isset($params[$k]))||(isset($params[$k]) && $params[$k] == ''))){
                            $params[$k] = $_route['options'][$k];
                        }
                    }
                }

                if(isset($_route['options'])){
                    foreach ($_route['options'] as $_option => $_value){
                        if($_value !== COMPULSORY && $_value !== OPTIONAL && $_value != '' && !isset($params[$_option])){
                            $params[$_option] = $_value;
                        }
                    }
                }
            }
            if(count($params)){
                $params = array_map(array(&$this,'_urlDecode'), $params);
                return $params;
            }
        }
        return false;
    }

	private function _urlDecode($input) {
        if(!empty($input)){
            if (is_scalar($input)){
                return urldecode($input);
            }elseif (is_array($input)){
                return array_map(array(&$this,'_urlDecode'),$input);
            }
        }
        return '';
    }

    private function _urlEncode($input) {
        if(!empty($input)){
            if (is_scalar($input)){
                return urlencode($input);
            }elseif (is_array($input)){
                return array_map(array(&$this,'_urlEncode'),$input);
            }
        }
        return '';
    }
	
	private function _getParsedUrl($url) {
		$url = parse_url($url);		
		if(empty($url['path'])) $url['path'] = '/';
				
		if(!empty($url['query'])) {
			$get = $this->_parseQuery($url['query']);
		} else {
			$get = array();
		}
		
		$url['query'] = array('get' => $get , 'post' => $_POST);
			
		return $url;
	}
	
	private function _parseQuery($var) {
		$var  = explode('&', $var);
		$arr  = array();

		foreach($var as $val) {
			$x          = explode('=', $val);
			$arr[$x[0]] = $x[1];
		}
		
		return $arr;
	}


}
?>