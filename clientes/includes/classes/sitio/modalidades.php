<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	class modalidades {
		
		private $db;
		private $vars;
		
		private $modalidad;
		private $ruta_modalidad;
		private $put_modalidad;
		private $ruta_modalidad_contenido;
		private $ruta_archivo_php;
		
		function __construct(){
		
			$this->vars = new data_exchange;
			
			//modalidad
			$sm = $this->vars->get("sm",'',false);
			if(!empty($sm)){
				$aux = explode("_",$this->vars->get("sm",'',false));
				$this->modalidad = $aux[0];
				if(!empty($aux[1])){
					$this->put_modalidad = $aux[1];
				}
				
				$this->ruta_modalidad = "modalidades/".$this->modalidad;
				$this->ruta_modalidad_contenido = "modalidades/".$this->modalidad."/contenidos/";
				$this->ruta_archivo_php = $this->ruta_modalidad_contenido.$this->put_modalidad.".php";
			}
		}
		
		function getModalidad(){
			return $this->modalidad;
		}
		
		function getIdModalidad(){
			return $this->db->getValue("id");
		}
		
		function getPutModalidad(){
			return $this->put_modalidad;
		}
		
		function getContenidoModalidad(){
			$this->db = new database;
			$this->db->query("SELECT * FROM modalidades WHERE nombre_dir LIKE '".$this->modalidad."'");
			$this->db->fetch();
		
			$put = $this->ruta_archivo_php;
			
			if($this->vars->checkXSS($put)){
				if (file_exists($this->ruta_archivo_php)){
					return $put;
				}
				else{
					return $this->ruta_modalidad_contenido."home.php";
				}
			}
		}
	}
?>