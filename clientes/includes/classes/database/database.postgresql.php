<?
	class database{
	
		private $id;
		
		private $result;
		private $row;
		
		private $error = true;
		
		function __construct(){

			$this->error = false;

			$this->id = mysql_connect(SERVER,USER,PASSWORD);
			
			if($this->id){
				mysql_select_db(DATABASE,$this->id);
				$this->error = true;
			}
		}
		
		function getError(){
			return($this->error);
		}
		
		function query($sql,$total=-1,$from=-1){

			$this->result = mysql_query($sql,$this->id) or die(mysql_error());

			if($this->result){
				$this->error = true;
			}else{
				$this->error = false;
			}
		}
		
		function getRows(){
			return(mysql_num_rows($this->result));
		}
		
		function fetch(){
			return($this->row = mysql_fetch_array($this->result));
		}
		
		function getValue($field){
			return($this->row[$field]);
		}
		
		function getValues(){
			return($this->row);
		}
		
		function close(){
			if($this->id){
				mysql_close($this->id);
			}
		}
		
		function escape($str){
		
			if(!get_magic_quotes_gpc()){
				$str = addslashes($str);
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