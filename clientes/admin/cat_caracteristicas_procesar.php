<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_ABM_PROCESS);

	$process = new ABMProcess('cat_caracteristicas','cat_caracteristicas','id_cat_caracteristica',$data->get('abm_accion'));

	$process->actualizar();
?>