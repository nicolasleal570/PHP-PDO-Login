<?php 

session_start();

$GLOBALS['config'] = array(
	'mysql' => array(
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'bd' => 'php-pdo-login'
	),
	'remember' => array(
		'cookie_name' => 'hash',
		'cookie_expiry' => 604800 //LA COOKIE SE VENCE EN UN MES
	),
	'session' => array(
		'session_name' => 'user'
	)
);

//CARGANDO AUTOMATICAMENTE LAS CLASES
spl_autoload_register(function($class){
	require_once 'classes/' . $class . '.php';
});

require_once 'functions/sanitize.php';

