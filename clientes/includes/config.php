<?
	define('CONFIG',true);
	
	//CONFIGURAR FECHA EN PAGINA
	date_default_timezone_set("America/Cordoba");
	setlocale(LC_ALL,"spanish");

	$_SERVER['DOCUMENT_ROOT'] = $_SERVER['DOCUMENT_ROOT']."/clientes";
	
	// DATABASE
	define('ENGINE','mysql');
	define('SERVER','127.0.0.1');
	define('DATABASE','mystery_'); //-- Not required in ORACLE --
	define('USER','mystery');
	define('PASSWORD','inglobe2014');

	define('DATABASE_ERROR','Error en la base de datos!');
	
	// LOGS
	
	// Directorio sobre el cual se almacenaran los LOGS
	define('LOGS_DIR',$_SERVER['DOCUMENT_ROOT'].'/logs/');
	
	// Nombres de arhivos de los diferentes logs
	define('LOGS_DATABASE','database.log');				// Errores de la base de datos
	define('LOGS_FILESYSTEM','filesystem.log');			// Errores en el sistema de archivos
	define('LOGS_PARAMETERS','parametros.log');			// Errores en la consulta de parametros no especificados
	define('LOGS_VALIDATIONS','validaciones.log');		// Errores en las validaciones
	define('LOGS_LOGIN','login.log');					// Falsos intentos de logueos
	define('LOGS_DATA_EXCHANGE','data_exchange.log');	// Errores en los datos suministrados por el usuario
	
	// URL
	define('URL','http://www.zephiaestudio.com.ar/mysterysur/public_html/clientes');
	
	// IDIOMA
	define('IDIOMA','es');
	
	// SKIN
	define('SKIN','gris');
	
	// ADMIN
	define('PAGINACION',50);	// Tamaño de la pagina
	define('VENTANA',7);		// Tamaño de la ventana del paginador
	
	// FOTOS
	define('PATH_FOTOS',$_SERVER['DOCUMENT_ROOT'].'/images/galeria/fotos/');
?>