<?
	if(!defined('PATHS') || !defined('CONFIG')){
		die('No se encontraron los archivos de configuración.');
	}

	define('PROCESOS_GLOBALES',true);
	
	require_once(PATH_DATABASE);
	require_once(PATH_DATABASE_FORMAT);
	require_once(PATH_FUNCIONES_GENERALES);
	require_once(PATH_PARAMETROS);
	require_once(PATH_LOGIN);
	require_once(PATH_DATA_EXCHANGE);
	
	$parametros = new parametros;
	
	$data = new data_exchange("ventas");
	
	if($data->post('login','',false) == 1){

		$loggin = new login($data->post('user'),$data->post('pass'));
		
		if($loggin->existe()){
			
			$data->session_set('id_usr',$loggin->getIdUsuario(),DATA_EX_TYPE_INT);
			$data->session_set('usr_user',$loggin->getUsuario());
			$data->session_set('usr_nombre',$loggin->getNombre()." ".$loggin->getApellido());
			$data->session_set('usr_foto',$loggin->getFoto());
			$data->session_set('usr_admin',$loggin->isAdmin());
			
			$data->session_logged();

		}else{
			
			$data->session_set('id_usr',-1,DATA_EX_TYPE_INT);
			$data->session_set('usr_user','');
			$data->session_set('usr_nombre','');
			$data->session_set('usr_foto','');
			$data->session_set('usr_admin',0);
			
			$error_login = true;
		}
	}
	
	if($data->get('logout','',false) == 1){
		$data->session_delete();
	}
	
	//IDIOMA
	//require_once(PATH_IDIOMA);
	
	if($data->session_is_logged()){
		//$usuarios_tmp = getUsrOnline();
	}
	
?>