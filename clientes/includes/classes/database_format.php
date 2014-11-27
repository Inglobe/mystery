<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_DATABASE);
	require_once(PATH_DATA_VALIDATION);
	
	/**
	 * Implementa las operaciones basicas para operar sobre una tabla en particular, 
	 * tales como el insert, select, update, delete.
	 */
	class database_format extends database {
	
		private $dv;
		
		/**
		 * Constructor de la clase
		 */
		function __construct(){
			parent::__construct();
			$this->dv = new data_validation;
		}
		
		/**
		 * Destructor de la clase
		 */
		function __destruct(){
			parent::__destruct();
		}

		function getXHTMLValue($data){
			
			$out = $this->getValue($data);
		
			$out = $this->dv->xhtmlOut($out);
		
			return($out);
		}
		
		function getURLValue($data){
			
			$out = $this->getValue($data);
		
			$out = rawurlencode($out);
		
			return($out);
		}
		
		function getCutedValue($data,$nro_car){
		
			$out = $this->getValue($data);
		
			$out = $this->dv->cut_text($out,$nro_car);
		
			return($out);
		}
		
		function getCutedXHTMLValue($data,$nro_car){
		
			$out = $this->getValue($data);
		
			$out = $this->dv->cut_text($out,$nro_car);
			
			$out = $this->dv->xhtmlOut($out);
		
			return($out);
		}
		
		function getStrippedTagValue($data){
		
			$out = $this->getValue($data);
		
			$out = strip_tags($out);
		
			return($out);
		}
	}
?>