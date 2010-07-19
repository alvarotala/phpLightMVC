<?
/**
 * Template class
 *
 * @package PPY
 * @author Alvaro Talavera <alvarotala@gmail.com>
 *
 * USAGE
 *	
 * + template.html
 *		<h1>Hello {$name}</h1>
 *		<p>This is an example, a variable loocks like {$this}, {$another}</p>
 *
 * + foo.php
 *		require_once('class.template.php');
 *		
 *		$tmpl = new Template("path/to/the/file/template.html");
 *		
 *		$tmpl->replace(array(
 *			'name' => 'Real content for this variable',
 *			'this' => 'Real content for this variable',
 *			'another' => 'Real content for this variable'
 *		));
 *		
 *		$output = $tmpl->render();
 **/

class Template{
    var $template;
    var $variables;

	 public function Template($template){      
        $this->template = @file_get_contents($template);
        $this->variables = array();
    }

    function __construct($template){      
        $this->template = @file_get_contents($template);
        $this->variables = array();
    }

    public function replace($array){
        if ( !is_array($array) ){
            return;
        }
        foreach ( $array as $name => $data ){
            $this->add($name, $data);
        }
        return;
    }

    public function render($direct_output = false){
        $template = addslashes($this->template);       
        foreach ( $this->variables as $variable => $data ){
            $$variable = $data;
        } 
        eval("\$template = \"$template\";");       
        if ( $direct_output ) {
            echo stripslashes($template);
        } else {
            return stripslashes($template);  
        }
    }

	 function add($var_name, $var_data){
        $this->variables[$var_name] = $var_data;
    }
}

?>
