<?php

	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_LOGS);
	
	/**
	 * Hace una abstraccion de la base de datos
	 */
	class database extends logs {
	
		/**
		 * Link a la base de datos
		 * @access private
		 * @var link_identifier Link a la base de datos
		 */
		private $id;
		
		/**
		 * Bind variable values
		 * @access private
		 * @var array Bind variables
		 */		
		private $binds = array();
		
		/**
		 * Resultado de ejecutar una consulta a la base de datos
		 * @access private
		 * @var resourse|bool
		 */
		private $result;

		/**
		 * Almacena la cantidad de filas devueltas por la ultima consulta
		 * @access private
		 * @var integer
		 */
		private $number_rows = -1;
		
		/**
		 * Contiene las tablas del sistema
		 * @access private
		 * @var array
		 */
		private $tables = array();
		
		/**
		 * Recupera una fila de resultado como una matriz asociativa 
		 * @access private
		 * @var array 
		 */
		private $row;
		
		/**
		 * Habilita o inhabilita futuras refenrecias al objecto en caso de error
		 * @access private
		 * @var bool
		 */
		private $error = true;
		
		/**
		 * Determina si la conexion con la base de datos fue establecida
		 * @access private
		 * @var bool
		 */
		private $is_open = false;
		
		/**
		 * Determina si se realizo una consulta
		 * @access private
		 * @var bool
		 */
		private $query_open = false;
		
		/**
		 * Constructor de la clase
		 * @param bool $new_instance Si crea una nueva instancia de mysql
		 */
		function __construct($new_instance = false){
		
			//echo "Database construct; ";

			parent::__construct();

			$this->error = false;
			$this->number_rows = -1;
			$this->query_open = false;

			// Oracle Charset accepted codes:
			
			// ISO-8859-1: WE8ISO8859P15
			// UTF-8: AL32UTF8

			if($new_instance){
				$this->id = oci_new_connect(USER,PASSWORD,SERVER,'WE8ISO8859P15');
			}else{
				$this->id = oci_connect(USER,PASSWORD,SERVER,'WE8ISO8859P15');
			}
			
			if($this->id){
				$this->error = true;
				$this->is_open = true;
			}else{
				$this->db_error(DATABASE_ERROR);
				$this->error = false;
				$this->is_open = false;
			}
		}
		
		/**
		 * Destructor de la clase
		 */
		function __destruct(){
			$this->close();
		}
		
		/**
		 * Consulta si hubo error en la ultima operacion.
		 * @return bool
		 */
		function getError(){
			return($this->error);
		}
		
		/**
		 * Bind variables for the query
		 * @param string mixed
		 */
		function bind($key,$value){
			$this->binds[$key] = $value;
		}
		
		/**
		 * Ejecuta una sentencia SQL
		 * @param string Sentencia SQL
		 * @param integer Total de registros devueltos
		 * @param integer Desde que fila se traen los resultados
		 *
		 * En MySQL seria
		 * LIMIT
		 *		from,total		 
		 */
		function query($sql,$total=0,$from=0){

			if($this->query_open){
				oci_free_statement($this->result);
			}
			
			$this->query_open = false;
			$this->error = false;
			$this->number_rows = -1;

			$sqlTemp = $sql;
			
			if($total > 0){
				$sqlTemp = "SELECT a.*, ROWNUM rnum FROM (".$sqlTemp.") a WHERE ROWNUM <= ".($from+$total)." ";
			}
			
			if($from > 0){
				$sqlTemp = "SELECT * FROM (".$sqlTemp.") WHERE rnum  >= ".($from+1)." ";
			}

			$this->result = oci_parse($this->id,$sqlTemp);

			if($this->result){
				
				foreach($this->binds as $key => $val){
					oci_bind_by_name($this->result,":".$key,$val);
				}
			
				if(oci_execute($this->result)){
					$this->error = true;
					$this->query_open = true;
				}else{
					$e = oci_error($this->result);
					$this->db_error($e['message'],$sql);
				}
			}else{
				$e = oci_error($this->result);
				$this->db_error($e['message'],$sql);
			}
			
			// Para calcular la cantidad de filas devueltas por la consulta			
			// NOTA:
			// oci_num_rows no devuelve las filas afectadas por un SELECT, y no hay ninguna funcion que
			// lo realice.

			if($this->error && $this->query_open){
				
				if(strncmp('SELECT',strtoupper(ltrim($sql)),6) == 0){
					
					$sqlTmp = "SELECT COUNT(*) AS TOTAL FROM (".$sqlTemp.")";
					$rTemp = oci_parse($this->id,$sqlTmp);
					foreach($this->binds as $key => $val){
						oci_bind_by_name($rTemp,":".$key,$val);
					}
					oci_execute($rTemp);
					$temp = oci_fetch_assoc($rTemp);
					$this->number_rows = $temp['TOTAL'];
					oci_free_statement($rTemp);
					
				}else{
					$this->number_rows = oci_num_rows($this->result);
				}
			}
			
			unset($this->binds);
			$this->binds = array();
		}
		
		/**
		 * Devuelve las filas afectadas por la ultima consulta
		 * @return int 
		 */
		function getRows(){
			return($this->number_rows);
		}
		
		/**
		 * Recupera una fila de resultado como una matriz asociativa y devuelve true o false segun 
		 * @return bool
		 */
		function fetch(){
		
			$ret = false;
			
			if($this->error && $this->result){
				
				$this->row = oci_fetch_assoc($this->result);
				
				if(is_array($this->row)){
					$this->row = array_change_key_case($this->row,CASE_LOWER);
					$ret = true;
				}
			}
			
			return($ret);
		}
		
		/**
		 * Devuelve el valor del campo
		 * @param string Nombre del campo
		 * @return mixed
		 */
		function getValue($field,$log=true){
		
			if(isset($this->row[$field])){
				if(is_object($this->row[$field])){
					return($this->row[$field]->read($this->row[$field]->size()));
				}else{
					return($this->row[$field]);
				}
			}else{
				if($log){
					$this->db_error('La columna '.$field.' no se encuentra en la consulta.');
				}
				return('');
			}
		}
		
		/**
		 * Recupera una fila de resultado como una matriz asociativa
		 * @return array
		 */
		function getValues(){
			return($this->row);
		}
		
		/**
		 * Cierra la conexion con la base de datos
		 */
		function close(){
		
			if($this->id && $this->is_open){
			
				// Chequeo si existe alguna consulta abierta
				if($this->query_open){
					oci_free_statement($this->result);
				}
			
				oci_close($this->id);
				$this->is_open = false;
			}
		}
		
		/**
		 * Escapa el string
		 * @param string
		 */
		function escape($str){
		
			if(!get_magic_quotes_gpc()){
				//$str = addslashes($str);
				$str = str_replace("'","''",$str);
				//$str = str_replace("&","&&",$str);
				//$str = str_replace("&","'&",$str);
			}
			
			return($str);
		}
		
		/**
		 * Devuelve las tablas del sistema
		 * @return unknown
		 */
		function tables(){
			
			$this->tables = array();
			
			$sql = "SELECT object_name FROM user_objects WHERE object_type = 'TABLE'";
			
			$this->query($sql);
			
			while($this->fetch()){
				$this->tables[] = $this->getValue('object_name');
			}
			
			return($this->tables);
		}
		
		/**
		 * Devuelve el SQL de la tabla
		 * @param string $table
		 * @return string
		 */
		function table_structure($table){
			
			$table = strtoupper($table);
			
			if(array_search($table,$this->tables)){
			
				$sql = "
					SELECT 
						dbms_metadata.get_ddl('TABLE', '".$this->escape($table)."') AS sql
					FROM 
						".$this->escape($table)."
				";
				
				$this->query($sql);
				$this->fetch();
				
				return($this->getValue('sql'));
				
			}else{
				
				if(count($this->tables) > 0){
					$this->db_error('La tabla '.$table.' no existe en la base de datos.');
				}
				
				return('');
			}
		}
		
		/**
		 * Devuelve el SQL para guardar una fecha
		 * @param string $date
		 * @return string
		 */
		function toDate($date){	// $date -> 'dd/mm/yyyy'
			return(" TO_DATE('".$this->escape($date)."','dd/mm/yy') ");
		}
		
		function fromDate($date){
		
			$fecha = '';
		
			$aux = explode(" ",$date);
			
			if(count($aux) == 2){
				$fecha = $aux[0];
			}
		}
	}

?>