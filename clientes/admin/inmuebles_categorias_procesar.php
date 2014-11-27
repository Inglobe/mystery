<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_ABM_PROCESS);

	$process = new ABMProcess('inmuebles_categorias','inmuebles_categorias','id_categoria',$data->get('abm_accion'));

	$process->actualizar();
?>