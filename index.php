<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/vendor/autoload.php';

$url = isset($_GET['url']) ? $_GET['url'] : 'test/test';
$parts = explode('/', $url);

$controller = isset($parts[0]) ? $parts[0] : 'test';
$function = isset($parts[1]) ? $parts[1] : 'test';
$parameters ='';

if (isset($parts)) {
	for ($i=2; $i < count($parts); $i++) { 
		$parameters .= $parts[$i].',';
	}
	$parameters = trim($parameters,',');
	$parameters = explode(",", $parameters);
}

$controller = "controller_".$controller;
$directory = 'src/controllers/'.$controller.'.php';

if (!file_exists($directory)) {
	die ('No exite el directorio: '.$directory);
	return;
}

require_once __DIR__. "/" .$directory;

if (!function_exists($function)) {
	die ('No exite la funcion: '.$function);
	return;
}

call_user_func($function, $parameters ?? []);

?>