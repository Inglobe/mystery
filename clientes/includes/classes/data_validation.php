<?
	define('DATA_VALIDATION',true);

	define('DATA_EX_TYPE_MAIL','mail');
	define('DATA_EX_TYPE_INT','integer');
	define('DATA_EX_TYPE_FLOAT','float');
	define('DATA_EX_TYPE_STR','string');
	define('DATA_EX_TYPE_FILE','file');
	define('DATA_EX_TYPE_BOOL','bool');
	define('DATA_EX_TYPE_ARRAY','array');
	
	define('DATA_EX_FILE_TYPE_IMG','img');
	define('DATA_EX_FILE_TYPE_DATA','data');

	class data_validation extends logs{
		
		private $files_types = array();
		
		/**
		 * Constructor
		 */
		function __construct(){
		
			$this->files_types[DATA_EX_FILE_TYPE_IMG] = array(
				'image/jpeg',
				'image/pjpeg',
				'image/png',
			);
			
			$this->files_types[DATA_EX_FILE_TYPE_DATA] = array();
		}

		/**
		 * Filtra los datos segun el tipo
		 *
		 * @param mixed $value
		 * @param string $tipo
		 * @return mixed
		 */
		function filter($value,$tipo=DATA_EX_TYPE_STR,$file_type=DATA_EX_FILE_TYPE_DATA){
			
			switch($tipo){

				case DATA_EX_TYPE_STR:
					$value = $this->filter_string($value);
					break;
				case DATA_EX_TYPE_INT:
					$value = $this->filter_int($value);
					break;
				case DATA_EX_TYPE_MAIL:
					$value = $this->filter_mail($value);
					break;
				case DATA_EX_TYPE_FLOAT:
					$value = $this->filter_float($value);
					break;
				case DATA_EX_TYPE_FILE:
					if(!$this->filter_file($value,$file_type)){
						$value = array();
					}
					break;
				case DATA_EX_TYPE_BOOL:
					$value = $this->filter_bool($value);
					break;
				case DATA_EX_TYPE_ARRAY:
					$value = $this->filter_array($value);
					break;
				default:
					$value = $value;
					break;
			}
			
			return($value);
		}
		
		/**
		 * Devuelve un valor default
		 *
		 * @param string $tipo
		 * @return mixed
		 */
		protected function return_default($tipo){

			switch ($tipo){
				
				case DATA_EX_TYPE_INT:
					$value = 0;
					break;
				case DATA_EX_TYPE_STR:
					$value = '';
					break;
				case DATA_EX_TYPE_MAIL:
					$value = '';
					break;
				case DATA_EX_TYPE_FLOAT:
					$value = 0.0;
					break;
				case DATA_EX_TYPE_FILE:
					$value = array();
					break;
				case DATA_EX_TYPE_BOOL:
					$value = false;
					break;
				case DATA_EX_TYPE_ARRAY:
					$value = array();
					break;
				default:
					$value = '';
					break;
			}
			
			return($value);
		}
		
		function check_email($email){
		
			$mail_correcto = 0;
			
			//compruebo unas cosas primeras
			if((strlen($email) >= 6) && (substr_count($email,'@') == 1) && (substr($email,0,1) != '@') && (substr($email,strlen($email)-1,1) != '@')){
			
			   if((!strstr($email,'\'')) && (!strstr($email,'"')) && (!strstr($email,'\\')) && (!strstr($email,'\$')) && (!strstr($email,' '))) {
				   
					//miro si tiene caracter.
					if(substr_count($email,'.')>= 1){
					  
						//obtengo la terminacion del dominio
						$term_dom = substr(strrchr ($email, '.'),1);
						 
						//compruebo que la terminación del dominio sea correcta
						if(strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,'@')) ){
						
							//compruebo que lo de antes del dominio sea correcto
							$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
							$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
							
							if($caracter_ult != '@' && $caracter_ult != '.'){
								$mail_correcto = 1;
							}
						}
					}
				}
			}
			
			if($mail_correcto){
				return true;
			}else{
				return false;
			}
		}
		
		function filter_id($valor){
			
			if(ctype_digit(strval($valor))){
				return $valor;
			}else{
				$this->validation_error('Error al validar ID: '.$valor);
				return($this->return_default(DATA_EX_TYPE_INT));
			}
		}
		
		function filter_int($valor){
			
			if(ctype_digit(strval($valor))){
				return $valor;
			}else{
				$this->validation_error('Error al validar como entero: '.$valor);
				return($this->return_default(DATA_EX_TYPE_INT));
			}
		}
		
		function filter_mail($valor){
			
			if(check_email($valor)){
				return $valor;
			}else{
				$this->validation_error('Error al validar como mail: '.$valor);
				return($this->return_default(DATA_EX_TYPE_MAIL));
			}
		}
		
		function filter_string($valor){
			
			if(is_string($valor)){
				return($this->xhtmlOut($valor));
			}else{
				$this->validation_error('Error al validar como string: '.$valor);
				return($this->return_default(DATA_EX_TYPE_STR));
			}
		}
		
		function filter_float($valor){
			
			if(is_numeric($valor)){
				return($valor);
			}else{
				$this->validation_error('Error al validar como float: '.$valor);
				return($this->return_default(DATA_EX_TYPE_FLOAT));
			}
		}
		
		/**
		 * $file contiene el mismo array que $_FILES[x]
		 */		
		function filter_file($file,$file_type=DATA_EX_FILE_TYPE_DATA){

			$msg = "";
			
			if(count($this->files_types[$file_type]) > 0){
				if(
					in_array($file['type'],$this->files_types[$file_type]) && 
					($file['size'] > 0) &&
					($file['error'] == 0)
				){
					return(true);
				}else{
				
					if(($file['name'] != "") || ($file['size'] > 0)){
						$msg .= "Nombre: ".$file['name']."\n";
						$msg .= "Tipo: ".$file['type']."\n";
						$msg .= "Tamano: ".$file['size'];
						$this->validation_error($msg);
					}
					
					return(false);
				}
			}else{
				if(
					($file['size'] > 0) &&
					($file['error'] == 0)
				){
					return(true);
				}else{
					if(($file['name'] != "") || ($file['size'] > 0)){
						$msg .= "Nombre: ".$file['name']."\n";
						$msg .= "Tipo: ".$file['type']."\n";
						$msg .= "Tamano: ".$file['size'];
						$this->validation_error($msg);
					}
					
					return(false);
				}
			}
		}
		
		function filter_bool($valor){
			
			if(is_bool($valor)){
				return($valor);
			}else{
				$this->validation_error('Error validando como booleano: '.$valor);
				return($this->return_default(DATA_EX_TYPE_BOOL));
			}
		}
		
		function filter_array($valor){
			
			if(is_array($valor)){
				return($valor);
			}else{
				$this->validation_error('Error validando el array: '.$valor);
				return($this->return_default(DATA_EX_TYPE_ARRAY));
			}
		}
		
		function cut_text($texto,$nro_car){
		
			if($nro_car <= strlen($texto)){
				$salida = substr($texto,0,$nro_car);
				$salida = substr($salida,0,strrpos($salida,' ')).'...';
				return($salida);
			}else{
				return($texto);
			}
		}
		
		private function xmlcharacters($string, $trans=''){
	
			$trans = is_array($trans) ? $trans : get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
			
			foreach ($trans as $k => $v){
				$trans[$k]= '&#'.ord($k).';';
			}
			
			return strtr($string,$trans);
		}
		
		function xhtmlOut($entrada){
			return nl2br($this->xmlcharacters($entrada));
		}
		
		function checkXSS(){
			//hacer el codigo
			return true;
		}
	}
?>