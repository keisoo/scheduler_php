<?php
	
	//config
	require 'config/database.php';
	require 'config/paths.php';
	require 'config/constants.php';

	// echo '<pre>';
	// var_dump($_SERVER);
	// echo '</pre>';
	// die();

	// Also spl_autoload_register (Take a look at it if you like)
	function __autoload($class) {
		require LIBS . $class .".php";
	}

	$app = new Router();
?>