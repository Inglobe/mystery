<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_ABM_PROCESS);

	$process = new ABMProcess('users','users','id_user',$data->get('abm_accion'));

	$process->actualizar();
?>