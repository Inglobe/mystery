<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_ABM_PROCESS);

	$process = new ABMProcess('groups','groups','id_group',$data->get('abm_accion'));

	$process->actualizar();
?>