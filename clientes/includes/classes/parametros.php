<?
	if(!defined('PATHS') || !defined('CONFIG')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_DATABASE);

	class parametros extends database {
	
		private $valores = array();
	
		function __construct(){
		
			parent::__construct();
			
			$sql = "
				SELECT 
					keyname,
					optvalue 
				FROM 
					options
			";
			
			$this->query($sql);
			
			while($this->fetch()){
				$this->valores[$this->getValue('keyname')] = $this->getValue('optvalue');
			}
		}
		
		function __get($valor){
			if(array_key_exists($valor,$this->valores)){
				return($this->valores[$valor]);
			}else{
				$this->parametros_error($valor);
				return('');
			}
		}
		
		function __set($key,$val){
			
			if(array_key_exists($key,$this->valores)){
				
				$sql = "
					UPDATE
						options
					SET
						optvalue = '".$this->escape($val)."'
					WHERE
						keyname LIKE '".$this->escape($key)."'
				";
				
				$this->query($sql);
				
				if($this->getError()){
					$this->valores[$key] = $val;
				}
				
			}else{
				$this->parametros_error($val,$key);
			}
		}
	}
?>