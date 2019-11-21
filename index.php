<?php
 
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
	
	include "Config/Autoload.php";
	include "Config/Config.php";

	use Config\Autoload as Autoload;
	use Config\Router 	as Router;
	use Config\Request 	as Request;
	
	use DAO\DAODB\Singleton as Singleton;
		
	Autoload::start();

	session_start();

	$first= true;

	Router::Route(new Request());

	require_once(VIEWS_PATH."footer.php");
?>