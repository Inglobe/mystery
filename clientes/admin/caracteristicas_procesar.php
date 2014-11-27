<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_ABM_PROCESS);

	$process = new ABMProcess('caracteristicas','caracteristicas','id_caracteristica',$data->get('abm_accion'));

	$process->actualizar();
?>