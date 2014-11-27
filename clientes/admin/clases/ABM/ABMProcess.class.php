<?
	if(!defined('CONFIG') || !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_DATABASE);
	require_once(PATH_FILESYSTEM);
	require_once(PATH_DATA_EXCHANGE);

	class ABMProcess extends database {
		
		private $datos = array();
		
		private $abm = "";
		private $tabla = "";
		private $id = "";
		private $accion = "";
		
		private $redireccionar = "";
		
		private $custom_redir = "";
		
		private $fs;
		private $data;
		
		private $serializeIt = "";
		
		function __construct($abm,$tabla,$id,$accion){
		
			parent::__construct();

			$this->fs = new filesystem;
			$this->data = new data_exchange();
						
			$this->abm = $abm;
			$this->tabla = $tabla;
			$this->id = $id;
			$this->accion = $accion;
			
			$this->redireccionar = $abm."_search";
			
			$this->serializeIt = $this->data->get_serialized();
			
			if($this->serializeIt != ''){
				$this->serializeIt = '&'.$this->serializeIt;
			}
			
			$this->datos = $this->makeDatosByPost($_POST,$_FILES);
		}
		
		function __destruct(){
			parent::__destruct();
		}
		
		private function makeDatosByPost($post_vars,$files_vars){
		
			$i = 0;
			
			$datos = array();
		
			foreach($post_vars as $clave => $variable_post){
			
				$aux = explode("_",$clave);
				$tipo = array_shift($aux);
				$nombre_campo = implode("_",$aux);
		
				if($tipo == "texto" || $tipo == "combo" || $tipo == "check" || $tipo == "date" || $tipo == "pass"){
					
					$datos[$i]["nombre_campo"] = $this->data->filter($nombre_campo);
					$datos[$i]["tipo_campo"] = $this->data->filter($tipo);
					
					switch($tipo){
						
						case 'date':
							
							$datos[$i]["valor_campo"] = $this->toDate($variable_post);
							break;
							
						case 'pass':
							
							if($variable_post != ''){
								$datos[$i]["valor_campo"] = md5($variable_post);
							}else{
								unset($datos[$i]);
							}
							break;
							
						default:
							
							$datos[$i]["valor_campo"] = $variable_post;
							break;
					}
					
					$i++;
				}
			}
		
			foreach($files_vars as $clave => $archivo_post){
				
				$aux = explode("_",$clave);
				$tipo = array_shift($aux);
				$nombre_campo = implode("_",$aux);
		
				$datos[$i]["nombre_campo"] = $nombre_campo;
				$datos[$i]["valor_campo"] = $archivo_post["name"];
				$datos[$i]["tipo_campo"] = $tipo;
		
				$i++;
			}
		
			return($datos);
		}
		
		private function agregarFoto($path,$nom_archivo){

			$nombre_archivo = '';
			
			$campo = "foto_".$nom_archivo;
			
			$tmp = $this->data->file($campo,DATA_EX_FILE_TYPE_IMG,false);
			
			if(!empty($tmp)){
				$nombre_archivo = rand(1,99999)."_".$tmp["name"];
				$this->fs->upload($tmp["tmp_name"],$path.$nombre_archivo);
			}
			
			return($nombre_archivo);
		}
		
		private function agregarArchivo($path,$nom_archivo){

			$nombre_archivo = '';
			
			$campo = "data_".$nom_archivo;
			
			$tmp = $this->data->file($campo,DATA_EX_FILE_TYPE_DATA,false);
			
			if(!empty($tmp)){
				$nombre_archivo = rand(1,99999)."_".$tmp["name"];
				$this->fs->upload($tmp["tmp_name"],$path.$nombre_archivo);
			}
			
			return($nombre_archivo);
		}
		
		private function checkArchivo($nom_campo,$path,$nom_archivo){
		
			$tmp = $this->data->file("data_".$nom_archivo);
			
			if(
				!empty($tmp) || 
				($this->data->post("borrar_".$nom_archivo,DATA_EX_TYPE_INT,true) == 1)
			){
			
				$sql = "
					SELECT 
						".$this->escape($this->data->filter($nom_campo))." 
					FROM 
						".$this->escape($this->data->filter($this->tabla))." 
					WHERE 
						".$this->id." = ".$this->escape($this->data->filter($this->data->get('id',DATA_EX_TYPE_INT)))."
				";
				
				$this->query($sql);
				$this->fetch();
				
				if($this->getValue($nom_campo) != ""){
					$this->fs->delete($path.$this->getValue($nom_campo));
				}
			}
		}
		
		private function agregar(){
		
			foreach($this->datos as $campos){
			
				$nombres_insert[] = $this->escape($this->data->filter($campos["nombre_campo"]));
				
				switch($campos["tipo_campo"]){
				
					case "foto":
					
						$path = $this->data->post("path_foto_".$campos["nombre_campo"]);
						$nom_archivo = $campos["nombre_campo"];
						
						$nombre_archivo = $this->agregarFoto($path,$nom_archivo);
						
						$valores_insert[] = "'".$this->escape($this->data->filter($nombre_archivo))."'";
						
						break;
					
					case "data":
						
						$path = $this->data->post("path_data_".$campos["nombre_campo"]);
						$nom_archivo = $campos["nombre_campo"];
						
						$nombre_archivo = $this->agregarArchivo($path,$nom_archivo);
						
						$valores_insert[] = "'".$this->escape($this->data->filter($nombre_archivo))."'";
						
						break;
						
					case "date":
						
						$valores_insert[] = $campos["valor_campo"];
						break;
					
					case "combo":
						$valores_insert[] = $this->escape($campos["valor_campo"]);
						break;
						
					default:
					
						if(strlen($campos["valor_campo"]) > 2000){
							$this->bind($campos["nombre_campo"],$this->escape($campos["valor_campo"]));
							$valores_insert[] = ":".$campos["nombre_campo"];
						}else{
							$valores_insert[] = "'".$this->escape($campos["valor_campo"])."'";
						}
						break;
				}
			}
			
			$sql = "
				INSERT INTO ".$this->tabla." (
					".implode(",",$nombres_insert)."
				) VALUES (
					".implode(",",$valores_insert)."
				)
			";
			//$this->query("SET DEFINE OFF");
			
			//echo $sql;
			
			$this->query($sql);
			
			$this->redireccionar = "index.php?put=".$this->abm."_search".$this->serializeIt;
			
			return $this->getInsertId();
		}
		
		private function modificar(){

			$stringq = "
				UPDATE 
					".$this->tabla." 
				SET 
			";
			
			$cont_campos_update = 0;
			$total_campos_update = count($this->datos);

			foreach($this->datos as $campos){
			
				switch($campos["tipo_campo"]){
				
					case "foto":

						$path = $this->data->post("path_foto_".$campos["nombre_campo"]);
						
						$nom_archivo = $campos["nombre_campo"];
						
						$nombre_archivo = $this->agregarFoto($path,$nom_archivo);

						$nom_archivo = $campos["nombre_campo"];
						$nom_campo = $campos["nombre_campo"];
						
						$this->checkArchivo($nom_campo,$path,$nom_archivo);
						
						if($this->data->post("borrar_".$campos["nombre_campo"],DATA_EX_TYPE_INT,false) != 1){
							
							$tmp = $this->data->file("foto_".$campos["nombre_campo"]);
							
							if(!empty($tmp)){
								$stringq .= (($cont_campos_update == $total_campos_update) || ($cont_campos_update == 0)) ? "" : ", ";
								$stringq .= $campos["nombre_campo"]." = '".$this->escape($nombre_archivo)."' ";
							}

						}else{
							$stringq .= (($cont_campos_update == $total_campos_update) || ($cont_campos_update == 0)) ? "" : ", ";
							$stringq .= $campos["nombre_campo"]." = '' ";
						}
						
						break;
						
					case "data":

						$path = $this->data->post("path_data_".$campos["nombre_campo"]);
						
						$nom_archivo = $campos["nombre_campo"];
						
						$nombre_archivo = $this->agregarArchivo($path,$nom_archivo);

						$nom_archivo = $campos["nombre_campo"];
						$nom_campo = $campos["nombre_campo"];
						
						$this->checkArchivo($nom_campo,$path,$nom_archivo);
						
						if($this->data->post("borrar_".$campos["nombre_campo"],DATA_EX_TYPE_INT,false) != 1){
							
							$tmp = $this->data->file("data_".$campos["nombre_campo"]);
							
							if(!empty($tmp)){
								$stringq .= (($cont_campos_update == $total_campos_update) || ($cont_campos_update == 0)) ? "" : ", ";
								$stringq .= $campos["nombre_campo"]." = '".$this->escape($nombre_archivo)."' ";
							}

						}else{
							$stringq .= (($cont_campos_update == $total_campos_update) || ($cont_campos_update == 0)) ? "" : ", ";
							$stringq .= $campos["nombre_campo"]." = '' ";
						}
						
						break;

					case "date":
						$stringq .= (($cont_campos_update == $total_campos_update) || ($cont_campos_update == 0)) ? "" : ", ";
						$stringq .= $campos["nombre_campo"]." = ".$campos["valor_campo"];
						break;

					case "combo":
						$stringq .= (($cont_campos_update == $total_campos_update) || ($cont_campos_update == 0)) ? "" : ", ";
						$stringq .= $campos["nombre_campo"]." = ".$this->escape($campos["valor_campo"]);
						break;
						
					default:

						$stringq .= (($cont_campos_update == $total_campos_update) || ($cont_campos_update == 0)) ? "" : ", ";
						if(strlen($campos["valor_campo"]) > 2000){
							$this->bind($campos["nombre_campo"],$this->escape($campos["valor_campo"]));
							$stringq .= $campos["nombre_campo"]." = :".$this->escape($campos["nombre_campo"]);
						}else{
							$stringq .= $campos["nombre_campo"]." = '".$this->escape($campos["valor_campo"])."'";
						}

						break;
				}
				
				$cont_campos_update++;
			}

			$stringq.= "
				WHERE 
					".$this->data->filter($this->id)." = ".$this->escape($this->data->filter($this->data->get('id',DATA_EX_TYPE_INT)))."
			";

			//$this->query("SET DEFINE OFF");
			echo $stringq;
			
			$this->query($stringq);
			
			$this->redireccionar = "index.php?put=".$this->abm."_search".$this->serializeIt;
			
			return $this->data->filter($this->data->get('id',DATA_EX_TYPE_INT));
		}
		
		private function eliminar(){
			
			$sql = "
				DELETE FROM 
					".$this->data->filter($this->tabla)." 
				WHERE 
					".$this->data->filter($this->id)." = ".$this->escape($this->data->get('id',DATA_EX_TYPE_INT));
			
			$this->query($sql);
			
			if($this->data->get('data_serialize') != ''){
				$this->redireccionar = "index.php?".urldecode($this->data->get('data_serialize',DATA_EX_TYPE_STR,false,false));
			}else{
				$this->redireccionar = "index.php?put=".$this->abm."_search";
			}
			
			return $this->data->filter($this->data->get('id',DATA_EX_TYPE_INT));
		}
		
		public function redireccionar(){
			?>
			<div id="contenido">
				<table width="100%" border="0" cellspacing="100" cellpadding="0">
					<tr>
						<td align="center"><img src="images/please_wait.gif" alt="please wait" /></td>
					</tr>
				</table>
			</div>
			<script language="JavaScript">
			<!--
			<?
				if(empty($this->custom_redir)){
			?>
				//setTimeout('window.location = "<?=$this->redireccionar?>&feed=<?=$this->accion?>&abm_accion=<?=$this->accion?>"', 1500);
			<?
				}
				else{
			?>
				//setTimeout('window.location = "<?=$this->custom_redir?>"', 1500);
			<?
				}
			?>
			//-->
			</script>
			<?
		}
		
		public function setRedir($url){
			$this->custom_redir = $url;
		}
		
		function actualizar($redireccionar=true){
		
			$id = 0;
			
			switch($this->accion){
				case "a":
					$id = $this->agregar();
					break;
				case "m":
					$id = $this->modificar();
					break;
				case "d":
					$id = $this->eliminar();
					break;
			}
			
			if($redireccionar){
				$this->redireccionar();
			}
			
			return $id;
		}
	}
?>