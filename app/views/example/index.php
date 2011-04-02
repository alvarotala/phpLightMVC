<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title><?=SITE_NAME?></title>
	
	<style type="text/css" media="screen">
		.flash { padding: 10px; } 
		.notice { background: #8FFF9F; color: green; }
		.error { background: #FFB0C6; color: red; }
	</style>
	
</head>

<body>
	
	<?Template::load('example.php');?>
	
	<?Flash::show()?>
	
	<h1>Example</h1>
	
	<h3>Asigned from controller:</h3>
	<p><?=$this->a_variable_name; ?></p>
	<p><?=$this->something_happen; ?></p>
	
	<h3>Params:</h3>
	<p><? String::pr($this->params); ?>
		
	<h3>Links Examples: (TODO: Improve this with helpers)</h3>
	<dl>
		<dt>With MOD_REWRITE</dt>
		<dd><a href="<?=WWW_PATH?>/example/messages">/example/messages</a></dd>
		
		<dd><a href="<?=WWW_PATH?>/example/index">/example/index</a></dd>
		<dd><a href="<?=WWW_PATH?>/example/show">/example/show</a></dd>
		<dd><a href="<?=WWW_PATH?>/example/show/1">/example/show/1</a></dd>
		<dd><a href="<?=WWW_PATH?>/example/show/1?other=2">/example/show/1?other=2</a></dd>
		<dd><a href="<?=WWW_PATH?>/mostrar/1">/mostrar/1</a></dd>
		
		<dd><a href="<?=WWW_PATH?>/example/show/1&other=10">/example/show/1&other=10</a></dd>
		<dd><a href="<?=WWW_PATH?>/mostrar/1&other=10">/mostrar/1&other=10</a></dd>
		<dd><a href="<?=WWW_PATH?>/mostrar/1/otra/10">/mostrar/1/otra/10</a></dd>
		<dd><a href="<?=WWW_PATH?>/mostrar_otro/1/10/cualquier-texto-extra-ignorado">/mostrar/1/otra2/10/cualquier-texto-extra-ignorado</a></dd>
	</dl>
	
	<dl>
		<dt>Without MOD_REWRITE</dt>
		<dd><a href="<?=WWW_PATH?>?url=/example/messages">/example/messages</a></dd>
		<dd><a href="<?=WWW_PATH?>?url=/example/index">/example/index</a></dd>
		<dd><a href="<?=WWW_PATH?>?url=/example/show">/example/show</a></dd>
		<dd><a href="<?=WWW_PATH?>?url=/example/show/1">/example/show/1</a></dd>
		<dd><a href="<?=WWW_PATH?>?url=/example/show/1&other=2">/example/show/1?other=2</a></dd>
		<dd><a href="<?=WWW_PATH?>?url=/mostrar/1">/mostrar/1</a></dd>
		
		<dd><a href="<?=WWW_PATH?>?url=/example/show/1&other=10">/example/show/1&other=10</a></dd>
		<dd><a href="<?=WWW_PATH?>?url=/mostrar/1&other=10">/mostrar/1&other=10</a></dd>
		<dd><a href="<?=WWW_PATH?>?url=/mostrar/1/otra/10">/mostrar/1/otra/10</a></dd>
		<dd><a href="<?=WWW_PATH?>?url=/mostrar_otro/1/10/cualquier-texto-extra-ignorado">/mostrar/1/otra2/10/cualquier-texto-extra-ignorado</a></dd>
		
	</dl>

</body>
</html>
