<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	class carreras {
		
		private $db;
		private $vars;
		
		private $carrera;
		private $ruta_carrera;
		private $put_carrera;
		private $ruta_carrera_contenido;
		private $ruta_archivo_php;
	
		function __construct(){
			
			$this->vars = new data_exchange;
			
			//carrera
			$sc = $this->vars->get("sc",'',false);
			if(!empty($sc)){
				$aux = explode("_",$this->vars->get("sc",'',false));
				$this->carrera = $aux[0];
				if(!empty($aux[1])){
					$this->put_carrera = $aux[1];
				}
				
				$this->ruta_carrera = "carreras/".$this->carrera;
				$this->ruta_carrera_contenido = "carreras/".$this->carrera."/contenidos/";
				$this->ruta_archivo_php = $this->ruta_carrera_contenido.$this->put_carrera.".php";
			}			
		}
		
		function getCarrera(){
			return $this->carrera;
		}
		
		function getIdCarrera(){
			return $this->db->getValue("id");
		}
		
		function getIdMentor(){
			return $this->db->getValue("usr_id_mentor");
		}
		
		function getIdTutor(){
			return $this->db->getValue("usr_id_tutor");
		}
		
		function getIdCoTutor(){
			return $this->db->getValue("usr_id_cotutor");
		}
		
		function getIdTutorRio4(){
			return $this->db->getValue("usr_id_tutor_rio4");
		}
		
		function getIdCotutorRio4(){
			return $this->db->getValue("usr_id_cotutor_rio4");
		}
		
		function getPutCarrera(){
			return $this->put_carrera;
		}
		
		function getContenidoCarrera(){
			$this->db = new database;
			$this->db->query("SELECT * FROM carreras WHERE nombre_dir LIKE '".$this->carrera."'");
			$this->db->fetch();
		
			$put = $this->ruta_archivo_php;
			
			if($this->vars->checkXSS($put)){
				if (file_exists($this->ruta_archivo_php)){
					return $put;
				}
				else{
					return $this->ruta_carrera_contenido."home.php";
				}
			}
		}
	}
?>