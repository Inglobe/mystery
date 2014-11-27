<?
	if(!defined('CONFIG')){
		die('No se encontraron los archivos de configuración.');
	}

	/**
	 * Registro de errores
	 */
	class logs{
		
		/**
		 * Constructor
		 */
		function __construct(){
			
		}
		
		private function register_error($logfile,$log){

			$log .= "\n-----\n";
			$log .= "Informacion: \n";
			$log .= "\t- Fecha: ".date("d/m/Y H:i:s")."\n";
			$log .= "\t- Agente: ".$_SERVER['HTTP_USER_AGENT']."\n";
			$log .= "\t- IP: ".$_SERVER['REMOTE_ADDR']."\n";
			$log .= "\t- Archivo: ".$_SERVER['SCRIPT_FILENAME']."\n";
			$log .= "\t- Metodo: ".$_SERVER['REQUEST_METHOD']."\n";
			$log .= "\t- GET: ".http_build_query($_GET)."\n";
			$log .= "\t- POST: ".http_build_query($_POST)."\n";
			$log .= "=====================================\n";

			try{
				$fd = fopen(LOGS_DIR.$logfile,"a+");
				fwrite($fd,$log);
				fclose($fd);
			}catch(Exception $e) {
            	trigger_error($e->getMessage());
        	}
		}
		
		/**
		 * Realiza un log de la base de datos
		 * @param string $msg Mensaje de error
		 * @param string $sql Sentencia SQL
		 */
		function db_error($msg,$sql=""){
		
			$log = "";
			$log .= "Mensaje: ".$msg."\n";
			
			if($sql != ""){
				$log .= "SQL: \n";
				$log .= $sql."\n";
			}
			
			$this->register_error(LOGS_DATABASE,$log);
		}
		
		function filesystem_error($msg){
			$this->register_error(LOGS_FILESYSTEM,$msg);
		}
		
		function parametros_error($key,$val=NULL){
		
			if($val != NULL){
				$msg = "La clave ".$key." no ha sido configurada para su uso.";
			}else{
				$msg = "La clave ".$val." con el valor ".$key." no ha sido configurada para su uso.";
			}
		
			$this->register_error(LOGS_PARAMETERS,$msg);
		}
		
		function validation_error($msg){
			$this->register_error(LOGS_VALIDATIONS,$msg);
		}
		
		function data_exchange_error($msg){
			$this->register_error(LOGS_DATA_EXCHANGE,$msg);
		}
		
		function login_error($usr){
		
			$msg = "El usuario ".$usr." ha intentado loguearse incorrectamente a las ".date("d/m/Y H:i:s")."\n";
		
			$this->register_error(LOGS_LOGIN,$msg);
		}
	}
?>