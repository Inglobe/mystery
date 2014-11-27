<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}
	
	require_once(PATH_DATA_VALIDATION);
	
	class data_exchange extends data_validation {
		
		/**
		 * Constructor de la clase
		 *
		 * @param string $session_name
		 */
		function __construct($session_name = "default"){
			
			parent::__construct();
			
			if(empty($_SESSION)){
				
				session_name($session_name);
				session_start();
				
				if(empty($_SESSION['isLogged'])){
					$_SESSION['isLogged'] = false;
				}
			}
			
			$put = $this->get('put','',false);
			
			if(empty($put)){
				$put = 'home';
			}else{
				if($this->checkXSS($put)){
					if (!file_exists($put.'.php')){
						$this->data_exchange_error('Inclusion erronea: '.$put);
						$put = 'error';
					}
				}
			}
			
			$_GET['put'] = $put;
		}

		/**
		 * Devuelve un valor de GET
		 *
		 * @param string $name
		 * @param string $tipo
		 * @param bool $log
		 * @param bool $filter
		 * @return string
		 */
		function get($name,$tipo=DATA_EX_TYPE_STR,$log=true,$filter=true){
			
			if(isset($_GET[$name])){
				if($filter){
					return($this->filter($_GET[$name],$tipo));
				}else{
					return($_GET[$name]);
				}
			}else{
				if($log){
					$this->data_exchange_error('Variable consultada por GET que no existe: '.$name);
				}
				return($this->return_default($tipo));
			}
		}

		/**
		 * Devuelve los parametros de la URL como un string
		 *
		 * @param bool $amp
		 * @return string
		 */
		function get_serialized($amp=true,$withoutSystemValues=true){
			
			$temp = $_GET;
			
			if($withoutSystemValues){
				unset($temp['put']);
				unset($temp['id']);			
				unset($temp['ls']);
				unset($temp['x']);
				unset($temp['y']);
				unset($temp['feed']);
				unset($temp['abm_accion']);
				unset($temp['direccion']);
				unset($temp['abm_filtrar']);
				unset($temp['data_serialize']);
				unset($temp['campo_ordenar']);
				
				foreach($_GET as $key=>$val){
					if(strncmp($key,'filtro_',7) == 0){
						unset($temp[$key]);
					}
				}
			}
			
			if($amp){
				return(http_build_query($temp,'&amp;'));
			}else{
				return(http_build_query($temp));
			}
		}
		
		function get_set($key,$val){
			$_GET[$key] = $val;
		}
		
		function get_unset($key){
			unset($_GET[$key]);
		}

		/**
		 * Devuelve un valor de POST
		 *
		 * @param string $name
		 * @param string $tipo
		 * @param bool $log
		 * @return string
		 */
		function post($name,$tipo=DATA_EX_TYPE_STR,$log=true){
			if(isset($_POST[$name])){
				return($this->filter($_POST[$name],$tipo));
			}else{
				if($log){
					$this->data_exchange_error('Variable consultada por POST que no existe: '.$name);
				}
				return($this->return_default($tipo));
			}
		}

		function post_unset($key){
			unset($_POST[$key]);
		}

		/**
		 * Devuelve un valor de SESSION
		 *
		 * @param string $name
		 * @param string $tipo
		 * @param bool $log
		 * @return string
		 */
		function session($name,$tipo=DATA_EX_TYPE_STR,$log=true){
			if(isset($_SESSION[$name])){
				return($this->filter($_SESSION[$name],$tipo));
			}else{
				if($log){
					$this->data_exchange_error('Variable consultada por SESSION que no existe: '.$name);
				}
				return($this->return_default($tipo));
			}
		}

		/**
		 * Setea una variable de SESSION
		 *
		 * @param string $name
		 * @param mixed $val
		 * @param string $tipo
		 */
		function session_set($name,$val,$tipo=DATA_EX_TYPE_STR){
			$_SESSION[$name] = $this->filter($val,$tipo);
		}
		
		/**
		 * Inicia la sesion del usuario (no de PHP);
		 */
		function session_logged(){
			$this->session_set('isLogged',true,DATA_EX_TYPE_BOOL);
		}
		
		/**
		 * Checkea si se ha iniciado sesion
		 *
		 * @return bool
		 */
		function session_is_logged(){
			return($this->session('isLogged',DATA_EX_TYPE_BOOL,false));
		}
		
		/**
		 * Destruye la session actual
		 */
		function session_delete(){
			session_destroy();
			unset($_SESSION);
			session_start();
			$_SESSION['isLogged'] = false;
		}

		function file($name,$file_type=DATA_EX_FILE_TYPE_DATA,$log=true){

			if(isset($_FILES[$name])){
				return($this->filter($_FILES[$name],DATA_EX_TYPE_FILE));
			}else{
				if($log){
					$this->data_exchange_error('Variable consultada por FILES que no existe: '.$name);
				}
				return(array());
			}
		}
		
		function getPut($ext = false){
			if($ext){
				return($this->get('put').'.php');
			}else{
				return($this->get('put'));
			}
		}
	}
?>