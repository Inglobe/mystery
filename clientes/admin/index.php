<?php
	
	ini_set('display_startup_errors','On');
	error_reporting(E_ALL);

	function handle_error($errno, $errstr,$error_file,$error_line){
		//echo "[$error_file] $errstr - $error_line";
	}
	
	//set error handler
	set_error_handler('handle_error');

	require_once('../includes/config.php');
	require_once('../includes/paths.php');
	
	require_once(PATH_ADMIN_PROCESOS_GLOBALES);
	
	if($data->session_is_logged()){
		$preview = false;
		require(PATH_ADMIN_MAIN);
	}else{
		require_once(PATH_ADMIN_LOGIN);
	}
?>