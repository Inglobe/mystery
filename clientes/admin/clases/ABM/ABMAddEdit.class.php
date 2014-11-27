<?
	if(!defined('CONFIG') && !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_DATABASE);
	require_once(PATH_DATA_EXCHANGE);
	
	class ABMAddEdit extends database {
	
		//PARAMETROS
		var $nombre;
		var $tabla;
		var $nombre_id;
		var $categoria;
		var $titulo;
		var $accion;
		var $id_modificar;
	
		//INTERNAS
		private $linkDB;
		private $campos = array();
		private $tabLabels = array();
		private $debug;
		
		public $hideSolapas = false;
		public $hideCancelButton = false;
		
		public $serializeIt = "";
	
		// DATA_EXCHANGE
		private $data;
	
		function __construct($nombre,$tabla,$nombre_id,$categoria,$titulo,$accion,$id_modificar = 0,$debug = false){
			
			parent::__construct();
			
			$this->data = new data_exchange;
			
			$this->nombre = $nombre;
			$this->tabla = $tabla;
			$this->nombre_id = $nombre_id;
			$this->categoria = $categoria;
			$this->titulo = $titulo;
			$this->accion = $accion;
			$this->id_modificar = $id_modificar;
			$this->debug = $debug;
			$this->tabLabels[0] = "Datos";
			
			$this->serializeIt = $this->data->get_serialized(false);
		}

		function __destruct(){
			parent::__destruct();
		}
		
		public function addTextField($label,$nombre_db,$valor,$caracteres_aceptados,$mascara = "",$ancho = 0,$maximo = 0,$validar = true,$texto_alert = "", $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["validar"] = $validar;
			$mat_campo["texto_alert"] = $texto_alert;
			$mat_campo["tipo"] = "text";
			$mat_campo["text_caracteres_aceptados"] = $caracteres_aceptados;
			$mat_campo["text_mascara"] = $mascara;
			$mat_campo["text_ancho"] = $ancho;
			$mat_campo["text_maximo"] = $maximo;
	
			$this->campos[] = $mat_campo;
		}
	
		public function addPassField($label,$nombre_db,$valor, $tabindex=0){
			
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "pass";
	
			$this->campos[] = $mat_campo;
		}
		
		public function addHiddenField($nombre_db,$valor, $tabindex=0){
		
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = "";
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "hidden";
	
			$this->campos[] = $mat_campo;
		}
	
		public function addTextArea($label,$nombre_db,$valor,$caracteres_aceptados,$mascara = "",$columnas = 0,$filas = 0,$validar = true, $texto_alert = "", $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "textarea";
			$mat_campo["validar"] = $validar;
			$mat_campo["texto_alert"] = $texto_alert;
			$mat_campo["textarea_caracteres_aceptados"] = $caracteres_aceptados;
			$mat_campo["textarea_mascara"] = $mascara;
			$mat_campo["textarea_columnas"] = $columnas;
			$mat_campo["textarea_filas"] = $filas;
	
			$this->campos[] = $mat_campo;
		}
	
		public function addRichText($label,$nombre_db,$valor,$alto, $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "richtext";
			$mat_campo["richtext_alto"] = $alto;
	
			$this->campos[] = $mat_campo;
		}
	
		public function addCombo($label,$nombre_db,$consultaSQL,$id_db,$campo_mostrar,$valor,$item_ninguno = "",$validar = true,$texto_alert = "", $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "combo";
			$mat_campo["validar"] = $validar;
			$mat_campo["texto_alert"] = $texto_alert;
			$mat_campo["combo_consultaSQL"] = $consultaSQL;
			$mat_campo["combo_id_db"] = $id_db;
			$mat_campo["combo_campo_mostrar"] = $campo_mostrar;
			$mat_campo["combo_item_ninguno"] = $item_ninguno;
	
			$this->campos[] = $mat_campo;
		}
	
		public function addDate($label, $nombre_db, $valor, $tabindex=0, $permitir_nulo = false, $valor_check = 0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "date";
			$mat_campo["date_permitir_nulo"] = $permitir_nulo;
			$mat_campo["date_valor_check"] = $valor_check;
	
			$this->campos[] = $mat_campo;
		}
	
		public function addFoto($label,$nombre_db,$valor,$ruta, $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "foto";
			$mat_campo["validar"] = true;
			$mat_campo["foto_ruta"] = $ruta;
	
			$this->campos[] = $mat_campo;
		}
	
		public function addFile($label,$nombre_db,$valor,$ruta, $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "file";
			$mat_campo["validar"] = true;
			$mat_campo["file_ruta"] = $ruta;
	
			$this->campos[] = $mat_campo;
		}
	
		public function addCheckBox($label,$nombre_db,$valor, $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["nombre_db"] = $nombre_db;
			$mat_campo["valor"] = $valor;
			$mat_campo["tipo"] = "checkBox";
	
			$this->campos[] = $mat_campo;
		}
	
		public function addHTML($label,$codigo, $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["HTML_codigo"] = $codigo;
			$mat_campo["tipo"] = "HTML";
	
			$this->campos[] = $mat_campo;
		}
		
		public function addSeparator($label="", $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["tipo"] = "separator";
	
			$this->campos[] = $mat_campo;
		}
		
		public function addPhotoGallery($label, $tabindex=0){
	
			$mat_campo["tabindex"] = $tabindex;
			$mat_campo["label"] = $label;
			$mat_campo["tipo"] = "photo_gallery";
			$mat_campo["nombre_db"] = "";
	
			$this->campos[] = $mat_campo;
		}
		
		public function extractSerializedValue($nombre){
			$out = false;
		
			$aux = explode("&",$this->serializeIt);
	
			foreach($aux as $campo){
				$aux2 = explode("=",$campo);
				
				if($aux2[0] == $nombre){
					$out = $aux2[1];
				}
			}
			
			return $out;
		}
		
		public function setTabLabel($tabindex, $label){
			$this->tabLabels[$tabindex] = $label;
		}
		
		private function getNroTabs(){
			$nros = array();
		
			foreach($this->campos as $campo){
				$nros[$campo["tabindex"]] = $campo["tabindex"];
			}
			
			//reset($this->campos);
			
			//print_r($nros);
			
			return $nros;
		}
	
		private function renderHeaders(){
			?>
			<script type="text/javascript">
			//<![CDATA[
			
				function validar(f){
					
					<?
						foreach($this->campos as $campo){
							
							if(isset($campo["validar"]) && ($campo["validar"] == true)){
								
								switch($campo["tipo"]){
									
									case "text":
									case "textarea":
										
										?>
										if(f.<?="texto_".$campo["nombre_db"]?>.value == ""){
											alert("<?=$campo["texto_alert"]?>");
											f.<?="texto_".$campo["nombre_db"]?>.focus();
											return false;
										}
										<?
										
										break;
										
									case "combo":
										
										?>
										if(f.<?="combo_".$campo["nombre_db"]?>.value == 0){
											alert("<?=$campo["texto_alert"]?>");
											f.<?="combo_".$campo["nombre_db"]?>.focus();
											return false;
										}
										<?
										
										break;
										
									case "foto":
										
										?>
										var extensiones_permitidas = new Array(".jpg",".png",".gif");
										var archivo = f.<?="foto_".$campo["nombre_db"]?>.value;
										var extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
										var permitida = false;
										
										for (var i = 0; i < extensiones_permitidas.length; i++) {
											if (extensiones_permitidas[i] == extension) {
												permitida = true;
												break;
											}
										}
										
										if(!permitida && archivo != ""){
											alert("Sólo se pueden subir archivos: " + extensiones_permitidas.join());
											return false;
										}
										<?
										
										break;
								}
							}
						}
					?>
					
					document.getElementById('agileUploaderSWF').submit();
					
					return false;
				}
	
			   /* var r = new Restrict("form_<?=$this->nombre?>");
	
			    r.onKeyRefuse = function(o, k){
					o.style.backgroundColor = "#fdc";
			    }
			    
			    r.onKeyAccept = function(o, k){
					if(k > 30){
						o.style.backgroundColor = "#ffffff";
					}
			    }*/
			    
			//]]>
			</script>
<?
		}
	
		private function renderTitulos(){
			?>
<div id="page_tittle">
  <div id="ico"><img src="images/ico_tit_default-trans.png" width="53" height="58" alt="" /></div>
  <h1> <span>
    <?=$this->categoria?>
    </span><span class="title_separator">/</span><span class="dark_color">
    <?=$this->titulo?>
    </span><span class="title_separator">/</span><span class="light_color">
    <?=$this->accion == "a"?"Agregar":"Editar"?>
    </span> </h1>
</div>
<?
		}
	
		private function renderSolapas(){
			?>
<div id="conteiner_btn_back">
  <div id="btn_back"><a href="index.php?put=<?=$this->nombre?>_search&abm_accion=s&amp;<?=$this->serializeIt?>"><img src="images/btn_back-trans.png" width="101" height="28" alt="" /></a></div>
</div>
<?
		}
	
		private function renderCampos($tab_index=0){
			
			require_once("ABMControls.class.php");
	
			foreach($this->campos as $campo){
				if($campo["tabindex"]==$tab_index){
					if($campo["tipo"]=="separator"){
						echo '<div class="separator">'.(empty($campo["label"])?'':'<h3 class="title_color">'.$campo["label"].'</h3>').'<span></span></div>';
					}
					else{
					?>
					  <div class="input <?=$campo["nombre_db"]?>">
						<label for="<?=$campo["tipo"]."_".$campo["nombre_db"]?>"><?=$campo["label"]?></label>
	  <?
						switch($campo["tipo"]){
							
							case "text":
								
								$control = new ABMControls("texto_".$campo["nombre_db"],"texto_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createTextField($this->data->xhtmlOut($campo["valor"]),$campo["text_caracteres_aceptados"],$campo["text_mascara"],$campo["text_ancho"],$campo["text_maximo"]);
								break;
								
							case "pass":
								
								$control = new ABMControls("pass_".$campo["nombre_db"],"pass_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createPassField("");
								break;
								
							case "hidden":
								
								$control = new ABMControls("texto_".$campo["nombre_db"],"texto_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createHiddenField($campo["valor"]);
								break;
								
							case "textarea":
								
								$control = new ABMControls("texto_".$campo["nombre_db"],"texto_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createTextArea($this->data->xhtmlOut($campo["valor"]),$campo["textarea_caracteres_aceptados"],$campo["textarea_mascara"],$campo["textarea_columnas"],$campo["textarea_filas"]);
								break;
								
							case "richtext":
								
								$control = new ABMControls("texto_".$campo["nombre_db"],"texto_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createRichText($campo["valor"],$campo["richtext_alto"]);
								break;
								
							case "combo":
							
								$control = new ABMControls("combo_".$campo["nombre_db"],"combo_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createCombo($campo["combo_consultaSQL"],$campo["combo_id_db"],$campo["combo_campo_mostrar"],$this->data->xhtmlOut($campo["valor"]),$campo["combo_item_ninguno"]);
								break;
								
							case "date":
								if(isset($campo["valor"])){
									$aux = $this->fromDate($campo["valor"]);
									if(count($aux) != ''){
										$campo["valor"] = $aux;
									}else{
										$campo["valor"] = date("d/m/Y");
									}
								}else{
									$campo["valor"] = date("d/m/Y");
								}
								$control = new ABMControls("date_".$campo["nombre_db"],"date_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createDatePicker($campo["valor"],$campo["date_permitir_nulo"],$campo["date_valor_check"]);
								break;
								
							case "foto":
								
								$control = new ABMControls("foto_".$campo["nombre_db"],"foto_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createPictureBox($campo["valor"],$campo["foto_ruta"]);
								break;
								
							case "file":
								
								$control = new ABMControls("data_".$campo["nombre_db"],"data_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createFileBox($campo["valor"],$campo["file_ruta"]);
								break;
								
							case "checkBox":
								
								$control = new ABMControls("check_".$campo["nombre_db"],"check_".$campo["nombre_db"],"form_".$this->nombre);
								$control->createCheckBoxRadio($campo["valor"]);
								break;
								
							case "HTML":
								
								echo $campo["HTML_codigo"];
								break;
								
							case "photo_gallery":
								
								$control = new ABMControls("gallery","gallery","form_".$this->nombre);
								$control->createPhotoGallery($this->data->filter_id($this->id_modificar), $this->tabla);
								break;
						}
					?>
					  </div>
	<?
					}
				}
			}
		}
	
		private function loadData(){
			
			$sql = "
				SELECT 
					* 
				FROM 
					".$this->escape($this->data->filter($this->tabla))." 
				WHERE 
					".$this->escape($this->data->filter($this->nombre_id))." = ".$this->escape($this->data->filter_id($this->id_modificar))."
			";
			
			$this->query($sql);
			
			$this->fetch();
		
			$i = 0;
			
			foreach($this->campos as $campo){
				if($campo["tipo"] != "HTML" && $campo["tipo"] != "separator" && $campo["tipo"] != "photo_gallery"){
					$this->campos[$i]["valor"] = $this->getValue($campo["nombre_db"],false);
				}
				$i++;
			}
		}
	
		public function show(){
			
			if($this->accion == "m"){
				$this->loadData();
			}
			
			$this->renderHeaders();
			$this->renderTitulos();
			if(!$this->hideSolapas){
				$this->renderSolapas();
			}
		?>
<div id="conteiner_feed_add" style="display: <?=$this->data->get("feed",DATA_EX_TYPE_STR,false) == "" ? "" : "none" ?>">
  <div id="feed_add">
    <div id="text_feed" style="display: <?=$this->data->get('feed',DATA_EX_TYPE_STR,false) == "a" ? "" : "none" ?>">
      <?
			if($this->data->get('feed',DATA_EX_TYPE_STR,false) == "a"){
				echo "Se agreg&oacute; un registro.";
			}
		?>
      <img src="images/ico_info.jpg" alt="" /> </div>
  </div>
</div>
<script type="text/javascript" language="javascript" src="js_library/jqtabs.js"></script>
<div id="conteniner_tabs">
	<ul class="tabs">
	<?
	$first = true;
	foreach($this->getNroTabs() as $tabindex){
	?>
    	<li <?=($first?'class="active"':'')?>><a href="#tab_<?=$tabindex?>"><?=$this->tabLabels[$tabindex]?></a></li>
	<?
		$first = false;
	}
	?>
    </ul>
</div>
<div class="block <?=$this->nombre?>_abm">
	<form action="index.php?put=<?=$this->nombre?>_procesar&amp;abm_accion=<?=$this->accion?>&amp;id=<?=$this->id_modificar?>&amp;<?=$this->serializeIt?>" method="post" enctype="multipart/form-data" name="form_<?=$this->nombre?>" id="form_<?=$this->nombre?>" onsubmit="return validar(this)">
	<?
	foreach($this->getNroTabs() as $tabindex){
	?>
	  <div id="tab_<?=$tabindex?>" class="tab_content">
		<fieldset>
			<?
				$this->renderCampos($tabindex);
			?>
		</fieldset>
	  </div>
	<?
	}
	?>
	  <div id="cont_btns_ok_cancel">
		<div id="btns_ok_cancel">
			<?
				if(!$this->hideCancelButton){
			?>
		  <div class="button_off"><a href="index.php?put=<?=$this->nombre?>_search&amp;<?=$this->serializeIt?>">Cancelar</a></div>
			<?
				}
			?>
		  <input name="Submit" class="gradient_theme" type="submit" value="Ok" />
		 </div>
	  </div>
	</form>
</div>
<script type="text/javascript">
//<![CDATA[

//]]>
</script>
<?
		}
	}
?>
