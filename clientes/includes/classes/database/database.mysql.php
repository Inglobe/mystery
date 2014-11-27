<?
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
		 * Resultado de ejecutar una consulta a la base de datos
		 * @access private
		 * @var resourse|bool
		 */
		private $result;
		
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
		 * Constructor de la clase
		 * @param bool $new_instance Si crea una nueva instancia de mysql
		 */
		function __construct($new_instance = false){

			parent::__construct();

			$this->error = false;

			$this->id = mysql_connect(SERVER,USER,PASSWORD,$new_instance);
			
			if($this->id){
				mysql_select_db(DATABASE,$this->id);
				$this->error = true;
				$this->is_open = true;
			}
		}
		
		/**
		 * Destructor de la clase
		 */
		function __destruct(){
			//$this->close();
		}
		
		/**
		 * Consulta si hubo error en la ultima operacion.
		 * @return bool
		 */
		function getError(){
			return($this->error);
		}
		
		/**
		 * Ejecuta una sentencia SQL
		 * @param string Sentencia SQL
		 */
		function query($sql,$total=-1,$from=-1){
			
			if($total > -1 && $from > -1 ){
				$sql.= " LIMIT ".$from.", ".$total;
			}
			else if($total > -1){
				$sql.= " LIMIT ".$total;
			}
			
			//echo "<hr />".$sql."<hr />";

			$this->result = @mysql_query($sql,$this->id);
			
			if($this->result){
				$this->error = true;
			}else{
				$this->db_error(mysql_error($this->id),$sql);
				die(DATABASE_ERROR);
				$this->error = false;
			}
		}
		
		/**
		 * Devuelve las filas afectadas por la ultima consulta
		 * @return int 
		 */
		function getRows(){
			return(mysql_num_rows($this->result));
		}
		
		/**
		 * Recupera una fila de resultado como una matriz asociativa y devuelve true o false segun 
		 * @return bool
		 */
		function fetch(){
			return($this->row = mysql_fetch_assoc($this->result));
		}
		
		/**
		 * Devuelve el valor del campo
		 * @param string Nombre del campo
		 * @return mixed
		 */
		function getValue($field){
			return($this->row[$field]);
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
				//mysql_close($this->id);
				$this->is_open = false;
			}
		}
		
		/**
		 * Escapa el string
		 * @param mixed
		 */
		function escape($str){
		
			if(!get_magic_quotes_gpc()){
				$str = mysql_real_escape_string($str);
			}
			
			return($str);
		}
		
		/**
		 * Devuelve las tablas del sistema
		 * @return unknown
		 */
		function tables(){
			
			$this->tables = array();
			
			$sql = "SELECT object_name AS table_name FROM user_objects WHERE object_type = 'TABLE';";
			
			$this->query($sql);
			
			while($this->fetch()){
				$this->tables[] = $this->getValue('table_name');
			}
			
			return($this->tables);
		}
		
		/**
		 * Convierte la fecha a MySQL
		 * @return unknown
		 */
		function toDate($date){	// $date -> 'dd/mm/yyyy'
			return(" STR_TO_DATE('".$this->escape($date)."','%d/%m/%Y') ");
		}
		
		/**
		 * Convierte la fecha a Humano
		 * @return unknown
		 */
		function fromDate($date){
		
			$fecha = '';
		
			$aux = explode(" ",$date);
			
			if(count($aux) == 2){
				$fecha = $aux[0];
			}
		}
		
		/**
		 * Devuelve las tablas del sistema
		 * @return unknown
		 */
		function getInsertId(){
			return mysql_insert_id($this->id);
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
	}

?>