<?

# Custom routes here

# Examples
$map->connect("/example/show/:id", array('controller' => 'example', 'action' => 'show'));
$map->connect("/mostrar/:id", array('controller' => 'example', 'action' => 'show'));
$map->connect("/mostrar/:id/otra/:other", array('controller' => 'example', 'action' => 'show'));
$map->connect("/mostrar_otro/:id/:other/*", array('controller' => 'example', 'action' => 'show'));


$map->connect("/login", array('controller' => 'example', 'action' => 'login'));

# Defaults
$map->connect("/", array('controller' => 'example', 'action' => 'index')); # Define an INDEX
$map->connect(":controller/:action/*");

?>