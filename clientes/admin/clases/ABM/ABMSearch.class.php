<?php

	if(!defined('CONFIG') && !defined('PATHS')){
		die('No se encontraron los archivos de configuración.');
	}

	require_once(PATH_DATABASE);
	require_once(PATH_DATA_EXCHANGE);
	
	class ABMSearch extends database {

		//PARAMETROS
		var $nombre;
		var $tabla;
		var $nombre_id;
		var $categoria;
		var $titulo;
		var $consulta;
		public $readOnly = false;
		public $customEditURL = "";
		public $customEditVars = array();
	
		//INTERNAS
		private $columnas = array();
		private $botones_columna = array();
		private $filtros = array();
		private $datos = array();
		private $relaciones;
		private $consultaPaginador;
		private $orden = array();
		private $id_tabla = 0;
		private $ls = 0;
		private $paginacion = 0;
		private $parametros_url = "";
		private $filtrosSQL = "";
		private $ordenSQL = "";
		private $nro_registros = 0;
		private $campo_orden = "";
		private $tiene_galeria = false;
		private $debug;
		private $addedHTML = "";
	
		private $isSerialized = false;
		private $serializeIt = "";
	
		// DATA_EXCHANGE
		private $data;

		function __construct($nombre,$tabla,$nombre_id,$categoria,$titulo,$consulta,$paginacion=PAGINACION,$debug = false){
			
			parent::__construct();
			
			$this->data = new data_exchange;
			
			$this->nombre = $nombre;
			$this->tabla = $tabla;
			$this->nombre_id = $nombre_id;
			$this->categoria = $categoria;
			$this->titulo = $titulo;
			$this->consulta = $consulta;
			$this->paginacion = $paginacion;
			$this->debug = $debug;
	
			$this->parametros_url = $this->data->get_serialized();

			$this->serializeIt = $this->data->get_serialized(false);
			$this->isSerialized = true;			
			
			$this->ls = $this->data->get('ls',DATA_EX_TYPE_INT,false);
		}
	
		public function setCampoOrden($campo){
			$this->campo_orden = $campo;
		}
	
		public function setGaleria(){
			$this->tiene_galeria = true;
		}
		
		public function setCustomEdit($url, $vars){
			$this->customEditURL = $url;
			$this->customEditVars = $vars;
		}
	
		public function addCol($campoDB,$campoMostrar,$titulo,$ancho,$tituloAlineacion,$datoAlineacion,$orden = false,$orden_direccion = "ASC",$campoMostrarPreTxt = "",$campoMostrarPostTxt = ""){
	
			$mat_col["campoDB"] = $campoDB;
			$mat_col["campoMostrar"] = $campoMostrar;
			$mat_col["titulo"] = $titulo;
			$mat_col["ancho"] = $ancho;
			$mat_col["tituloAlineacion"] = $tituloAlineacion;
			$mat_col["datoAlineacion"] = $datoAlineacion;
			$mat_col["campoMostrarPreTxt"] = $campoMostrarPreTxt;
			$mat_col["campoMostrarPostTxt"] = $campoMostrarPostTxt;
	
			$this->columnas[] = $mat_col;
	
			if($orden){
				$mat_orden["campoDB"] = $campoDB;
				$mat_orden["direccion"] = $orden_direccion;
	
				$this->orden[] = $mat_orden;
			}
		}
	
		public function addButtonCol($href_path,$icon_path,$alt_text,$ancho_ventana,$alto_ventana,$target=""){
	
			$mat_col["href_path"] = $href_path;
			$mat_col["icon_path"] = $icon_path;
			$mat_col["alt_text"] = $alt_text;
			$mat_col["ancho_ventana"] = $ancho_ventana;
			$mat_col["alto_ventana"] = $alto_ventana;
			$mat_col["target"] = $target;
	
			$this->botones_columna[] = $mat_col;
		}
	
		public function addFilter($tipo,$campoDB,$label,$ancho = 12,$consulta = "",$campoMostrar = "",$item_ninguno = "",$estilo = ""){
			
			$mat_filtro["tipo"] = $tipo;
			$mat_filtro["campoDB"] = $campoDB;
			$mat_filtro["label"] = $label;
			$mat_filtro["ancho"] = $ancho;
			$mat_filtro["consulta"] = $consulta;
			$mat_filtro["campoMostrar"] = $campoMostrar;
			$mat_filtro["item_ninguno"] = $item_ninguno;
			$mat_filtro["estilo"] = $estilo;
	
			$this->filtros[] = $mat_filtro;
		}
	
		public function addRelacion($tabla,$campo){
			
			$mat_relacion["tabla"] = $tabla;
			$mat_relacion["campo"] = $campo;
	
			$this->relaciones[] = $mat_relacion;
		}
	
		public function addHTML($codigo){
			$this->addedHTML[] = $codigo;
		}
	
		private function getOrdenSQL($columna=""){
			
			$salida = "";
	
		 	if(!is_array($_SESSION["orden_".$this->nombre])){
		 		$_SESSION["orden_".$this->nombre] = $this->orden;
		 	}
			
			//print_r($_SESSION);
	
			$mat_orden = $_SESSION["orden_".$this->nombre];
	
			$encontrado = false;
			
			for($i = 0; $i < sizeof($mat_orden); $i++){
				
				if($mat_orden[$i]["campoDB"] == $columna){
					
					if($i == 0){
						if($mat_orden[$i]["direccion"] == "ASC"){
							$mat_orden[$i]["direccion"] = "DESC";
						}else{
							$mat_orden[$i]["direccion"] = "ASC";
						}
					}else{
						$aux[0]["campoDB"] = $mat_orden[$i]["campoDB"];
						$aux[0]["direccion"] = $mat_orden[$i]["direccion"];
						$encontrado = true;
					}
				}
				
				if($encontrado){
					
					echo "fila ".$i."<br>".print_r($mat_orden,true);
					
					$mat_orden[$i]["campoDB"] = $mat_orden[$i+1]["campoDB"];
					$mat_orden[$i]["direccion"] = $mat_orden[$i+1]["direccion"];
				}
			}
			
			if($encontrado){
				$temp = array_pop($mat_orden);
				$mat_orden = array_merge($aux,$mat_orden);
			}
			
			$salida .= $mat_orden[0]["campoDB"]." ".$mat_orden[0]["direccion"];
			
			for($i = 1; $i < sizeof($mat_orden); $i++){
				$salida .= ", ".$mat_orden[$i]["campoDB"]." ".$mat_orden[$i]["direccion"];
			}
	
			$this->data->session_set("orden_".$this->nombre,$mat_orden,DATA_EX_TYPE_ARRAY);
	
			return $salida;
		}
	
		private function ordenarRegistro($id,$direccion,$orden_consulta = ""){
	
			$db = new database;
			
			if($orden_consulta == ""){
				$consulta = "
					SELECT 
						".$this->escape($this->data->filter($this->campo_orden)).", 
						".$this->escape($this->data->filter($this->nombre_id))." 
					FROM 
						".$this->escape($this->data->filter($this->tabla))." 
					ORDER BY 
						".$this->escape($this->data->filter($this->campo_orden))." ASC
				";
			}else{
				$consulta = $this->consulta." 
					ORDER BY 
						".$this->escape($this->data->filter($orden_consulta))."
				";
			}
	
			$this->query($consulta);
	
			$nro_registros = $this->getRows();
	
			$cont = 0;
			
			while($this->fetch()){
				
				$cont++;
				
				$sql = "
					UPDATE 
						".$this->escape($this->data->filter($this->tabla))." 
					SET 
						".$this->escape($this->data->filter($this->campo_orden))." = ".$cont." 
					WHERE 
						".$this->escape($this->data->filter($this->nombre_id))." = ".$this->escape($this->data->filter($this->getValue($this->nombre_id),DATA_EX_TYPE_INT))."
				";
	
				$db->query($sql);
			}
	
			$sql = "
				SELECT 
					".$this->escape($this->data->filter($this->campo_orden))." 
				FROM 
					".$this->escape($this->data->filter($this->tabla))." 
				WHERE 
					".$this->escape($this->data->filter($this->nombre_id))." = ".$this->escape($this->data->filter($id,DATA_EX_TYPE_INT))."
			";
			
			$this->query($sql);
			$this->fetch();
			
			$orden_campo_seleccionado = $this->getValue($this->campo_orden);
	
			switch($direccion){
				
				case "up":
					
					if($orden_campo_seleccionado > 1){
						
						$sql = "
							SELECT 
								".$this->escape($this->data->filter($this->nombre_id))." 
							FROM 
								".$this->escape($this->data->filter($this->tabla))." 
							WHERE 
								".$this->escape($this->data->filter($this->campo_orden))." = ".$this->escape($this->data->filter($orden_campo_seleccionado - 1,DATA_EX_TYPE_INT))."
						";
						
						$this->query($sql);
						$this->fetch();
						
						$id_campo_afectado = $this->getValue($this->nombre_id);
						
						$sql = "
							UPDATE 
								".$this->escape($this->data->filter($this->tabla))." 
							SET 
								".$this->escape($this->data->filter($this->campo_orden))." = ".$this->escape($this->data->filter($orden_campo_seleccionado - 1,DATA_EX_TYPE_INT))." 
							WHERE 
								".$this->escape($this->data->filter($this->nombre_id))." = ".$this->escape($this->data->filter($id,DATA_EX_TYPE_INT))."
						";
						
						$this->query($sql);
						
						$sql = "
							UPDATE 
								".$this->escape($this->data->filter($this->tabla))." 
							SET 
								".$this->escape($this->data->filter($this->campo_orden))." = ".$this->escape($this->data->filter($orden_campo_seleccionado,DATA_EX_TYPE_INT))." 
							WHERE
								".$this->escape($this->data->filter($this->nombre_id))." = ".$this->escape($this->data->filter($id_campo_afectado,DATA_EX_TYPE_INT))."
						";
						
						$this->query($sql);
					}
					
					break;
					
				case "down":
					
					if($orden_campo_seleccionado < $nro_registros){
						
						$sql = "
							SELECT 
								".$this->escape($this->data->filter($this->nombre_id))." 
							FROM 
								".$this->escape($this->data->filter($this->tabla))." 
							WHERE 
								".$this->escape($this->data->filter($this->campo_orden))." = ".$this->escape($this->data->filter($orden_campo_seleccionado + 1,DATA_EX_TYPE_INT))."
						";
						
						$this->query($sql);
						$this->fetch();
						
						$id_campo_afectado = $this->getValue($this->nombre_id);
	
						$sql = "
							UPDATE 
								".$this->escape($this->data->filter($this->tabla))." 
							SET 
								".$this->escape($this->data->filter($this->campo_orden))." = ".$this->escape($this->data->filter($orden_campo_seleccionado + 1,DATA_EX_TYPE_INT))." 
							WHERE 
								".$this->escape($this->data->filter($this->nombre_id))." = ".$this->escape($this->data->filter($id,DATA_EX_TYPE_INT));
						
						$this->query($sql);

						$sql = "
							UPDATE 
								".$this->escape($this->data->filter($this->tabla))." 
							SET 
								".$this->escape($this->data->filter($this->campo_orden))." = ".$this->escape($this->data->filter($orden_campo_seleccionado,DATA_EX_TYPE_INT))." 
							WHERE 
								".$this->escape($this->data->filter($this->nombre_id))." = ".$this->escape($this->data->filter($id_campo_afectado,DATA_EX_TYPE_INT))."
						";
	
						$this->query($sql);
					}
					
					break;
			}
		}
	
		private function makeDatos(){
	
			//ordenar registro
			if(isset($_GET["direccion"])){
				$this->ordenarRegistro($_GET["id"],$_GET["direccion"]);
			}
	
			//filtros
			foreach($this->filtros as $filtro){
				
				$valor_tmp = $this->data->get("filtro_".str_replace(".","",$filtro["campoDB"]),DATA_EX_TYPE_STR,false);
				
				switch($filtro["tipo"]){
					
					case "textField":
						
						/* Remover las funciones UPPER para que funciones en Mysql */
						if(isset($valor_tmp) && ($valor_tmp != "")){
							$this->filtrosSQL .= " AND UPPER(".$filtro["campoDB"].") LIKE UPPER('%".$this->escape($this->data->filter($valor_tmp))."%') ";
						}
						
	            		break;
	            		
	            	case "combo":
	            		
	            		if(isset($valor_tmp) && ($valor_tmp != 0)){
							$this->filtrosSQL .= " AND ".$filtro["campoDB"]." = ".$this->escape($this->data->filter($valor_tmp,DATA_EX_TYPE_INT))." ";
						}
						
	            		break;
	            		
	            	case "date":
	            		
	            		if(isset($_GET["filtro_".$filtro["campoDB"]."_check"])){
							$this->filtrosSQL .= " AND ".$filtro["campoDB"]." = '".$this->escape(convertirFechaParaMySQL($valor_tmp))."' ";
						}
						
	            		break;
	            }
			}
	
			//consulta DB
			$consulta = $this->consulta;
	
			if(stripos($consulta, "where") === false && $this->filtrosSQL != ""){
				$consulta .= "
					WHERE 1 = 1
				";
			}

			$consulta .= $this->filtrosSQL;

			if($this->campo_orden == ""){
				if($this->data->get("campo_ordenar") != ""){
					$consulta .= "
						ORDER BY 
							".$this->escape($this->getOrdenSQL($_GET["campo_ordenar"]))."
					";
				}
				else{
					$consulta .= "
						ORDER BY 
							".$this->escape($this->getOrdenSQL())."
					";
				}
			}else{
				$consulta .= "
					ORDER BY 
						".$this->escape($this->data->filter($this->campo_orden))." ASC
				";
			}

			$this->consultaPaginador = $consulta;
	
			if($this->debug){
				echo "<hr>".$consulta."<hr>";
			}
	
			$this->query($consulta,$this->paginacion,$this->ls);
			
			$this->nro_registros = $this->getRows();
	
			while($this->fetch()){
				$this->datos[] = $this->getValues();
			}
		}
	
		private function renderHeaders(){
			?>
<script type="text/javascript" src="../includes/eventListener.js"></script>
<script type="text/javascript" src="../includes/inputMask.js"></script>
<script type="text/javascript" src="../includes/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="clases/ABMControls/datePicker/scripts/fsdateselect.js"></script>
<link type="text/css" rel="stylesheet" href="clases/ABMControls/datePicker/styles/fsdateselect.css" />
<script type="text/javascript">
			//<![CDATA[

				function validar(f){
					return true;
				}
	
			    var r = new Restrict("form_<?=$this->nombre?>");
	
			    /*r.onKeyRefuse = function(o, k){
			        o.style.backgroundColor = "#fdc";
			    }
			    r.onKeyAccept = function(o, k){
			        if(k > 30)
			            o.style.backgroundColor = "#ffffff";
			    }*/
			//]]>
			</script>
<?
		}
	
		private function renderTitulos(){
			?>
<div id="page_tittle">
<div id="ico"><img src="images/ico_tit_default-trans.png" alt="" /></div>
  <h1><span>
    <?=$this->categoria?>
    </span><span class="title_separator">/</span><span class="dark_color">
    <?=$this->titulo?>
    </span><span class="title_separator">/</span><span class="light_color">Buscar</span> </h1>
</div>
<?
		}
	
		private function renderSolapas(){
			$serial = ($this->isSerialized) ? '&amp;'.$this->serializeIt : '';
			?>
<div id="btns_sup">
  <div class="button gradient_theme"><a href="index.php?put=<?=$this->nombre?>_am&abm_accion=a<?=$serial?>">Agregar</a></div>
  </a> </div>
<?
		}
		
		private function renderHTML(){
			
			if(is_array($this->addedHTML)){
				foreach($this->addedHTML as $html){
					echo $html;
				}
			}
		}
	
		private function renderfiltros(){
			
			require(PATH_ABM_CONTROLS);
	
			if(count($this->filtros) > 0){
				?>
  <form id="form_<?=$this->nombre?>" name="form_<?=$this->nombre?>" method="get" action="index.php">
    <fieldset id="campos" >
      <legend style="display:none;">filtros</legend>
      <input type="hidden" name="put" value="<?=$this->nombre?>_search" />
      <input type="hidden" name="abm_filtrar" value="1" />
      <?
					$in = explode("&",$this->serializeIt);
					
					foreach($in as $val){
						$input = explode("=",$val);
						if(!empty($input[0]) && empty($input[1])){
				?>
      <input type="hidden" name="<?=$input[0]?>" value="<?=$input[1]?>" />
      <?
						}
					}
				
		        foreach($this->filtros as $filtro){
		        	$campoDB_limpio = str_replace(".","",$filtro["campoDB"]);
		        ?>
      <div class="input">
        <label for="id_filtro_<?=$campoDB_limpio?>"><?=$filtro["label"]?>:</label>
        <?
						$valor_tmp = $this->data->get("filtro_".$campoDB_limpio);
						
						$control = new ABMControls("filtro_".$campoDB_limpio,"id_filtro_".$campoDB_limpio,"form_".$this->nombre);
						
						switch($filtro["tipo"]){
							
							case "textField":
								
								$control->createTextField($valor_tmp,"\\\\.","",$filtro["ancho"]);
			            		break;
			            		
			            	case "combo":
			            		
								$control->createCombo($filtro["consulta"],$filtro["campoDB"],$filtro["campoMostrar"],$valor_tmp,$filtro["item_ninguno"]);
			            		break;
			            		
			            	case "date":
			            		
			            		$control = new ABMControls("filtro_".$campoDB_limpio,"id_filtro_".$campoDB_limpio,"form_".$this->nombre,"","",!$this->data->get("filtro_".$campoDB_limpio."_check"));
								$control->createDatePicker($valor_tmp,true,$this->data->get("filtro_".$campoDB_limpio."_check"));
			            		break;
			            }
		            ?>
      </div>
      <?
				}
				?>
	  <div id="cont_btns_ok_cancel">
        <div id="btns_ok_cancel">
          <div class="button gradient_theme"><a href="index.php?put=<?=$this->data->getPut()?>&amp;<?=$this->serializeIt?>">Todos</a></div>
          <input name="Submit" type="submit" value="Buscar" class="gradient_theme" />
        </div>
      </div>
    </fieldset>
  </form>
<?
			}
		}
	
		private function renderTablaResultados(){
			
			?>
<script type="text/javascript">
//<![CDATA[
	function confirmDelete(){
		return confirm("Esta seguro de borrar el registro?");
	}
//]]>	
</script>
<div class="table_list">
  <table width="100%" border="0" cellpadding="0" cellspacing="0" id="tabla_search">
    <thead>
      <tr>
	    <th width="1%"><input type="checkbox" name="check_all" value="1" id="check_all" /></th>
        <?
					foreach($this->columnas as $columna){
				?>
        <th width="<?=$columna["ancho"]?>" align="<?=$columna["tituloAlineacion"]?>"> <?
						$tmp = $this->data->session("orden_".$this->nombre,DATA_EX_TYPE_ARRAY,false);
						
						if(count($tmp) > 0){
						
							$i_orden = 0;
						
							foreach($tmp as $orden){
								
								$i_orden++;
								
								if($columna["campoDB"] == $orden["campoDB"]){
				?>
          <a href="<?=$_SERVER['PHP_SELF'].'?put='.$this->nombre.'_search&'.$this->parametros_url."&amp;campo_ordenar=".$columna["campoDB"]?>">
          <?=$columna["titulo"]?>
          <?php /*?><img src="images/flecha_<?=($orden["direccion"]=="ASC"?"arriba":"abajo")?>_blanca_<?=($i_orden==1)?"on":"off"?>.gif" alt="" hspace="5" border="0"/> <?php */?></a>
          <?
								}
							}
						
							reset($this->orden);
						
						}else{
							echo $columna["titulo"];
						}
				?>
        </th>
        <?
					}

					if($this->campo_orden !== ""){
						$col_orden = 1;
	                ?>
        <th width="6%">&nbsp;</th>
        <?
		                }else{
							$col_orden = 0;
						}

						if($this->tiene_galeria){
							
							$col_galeria = 1;
	                ?>
        <th width="1%">&nbsp;</th>
        <?
	                	}else{
							$col_galeria = 0;
						}
						
						foreach($this->botones_columna as $boton){
	                ?>
        <th width="1%">&nbsp;</th>
        <?
	                	}

						if(!$this->readOnly){
					?>
        <th width="1%">&nbsp;</th>
        <?
	                	}
	                ?>
      </tr>
    </thead>
    <tbody>
      <?
				if(count($this->datos) == 0){
	            ?>
      <tr>
        <td  colspan="<?=count($this->columnas)+1+$col_orden+$col_galeria?>" class="light_row" align="center"> No se encontraron registros. </td>
      </tr>
      <?
	            }
	            
	            $estilo_fila = "dark_row";
	            
	            $temp = urlencode($this->data->get_serialized(false,false));
	            
				$serial = ($this->isSerialized) ? '&amp;'.$this->serializeIt : '';
				
				foreach($this->datos as $fila){
				
					$estilo_fila = ($estilo_fila == "light_row" ? "dark_row" : "light_row");

					if(empty($this->customEditURL)){
						$href_modificar = "index.php?put=".$this->nombre."_am&id=".$fila[$this->nombre_id]."&abm_accion=m";
					}else{
						$serialized_custom_vars = "";
					
						foreach($this->customEditVars as $clave_custom_var => $valor_custom_var){
							$serialized_custom_vars.="&".$clave_custom_var."=".$fila[$valor_custom_var];
						}
					
						$href_modificar = $this->customEditURL.$serialized_custom_vars;
					}
					
					$href_modificar .= $serial;
					$href_eliminar = "index.php?put=".$this->nombre."_procesar&id=".$fila[$this->nombre_id]."&abm_accion=d";
					$href_fotos = "javascript:MM_openBrWindow('gallery_pop.php?id_relacion=".$fila[$this->nombre_id]."&nombre_abm=".$this->nombre."','','width=850,height=530')";
	            ?>
      <tr class="<?=$estilo_fila?>">
	    <td><input type="checkbox" name="checks[]" value="<?=$fila[$this->nombre_id]?>" id="check_<?=$fila[$this->nombre_id]?>" /></td>
        <?
	                	foreach($this->columnas as $columna){
	                ?>
        <td align="<?=$columna["datoAlineacion"]?>"><?
		                  	if(!$this->readOnly || !empty($this->customEditURL)){
						  ?>
          <a href="<?=$href_modificar?>">
          <?
						  	}
						  ?>
          <?=$this->data->xhtmlOut($columna["campoMostrarPreTxt"].$fila[$columna["campoMostrar"]].$columna["campoMostrarPostTxt"])?>
          <?
		                  	if(!$this->readOnly || !empty($this->customEditURL)){
						  ?>
          </a>
          <?
						  	}
						  ?></td>
        <?
	                	}
	                
						if($this->campo_orden !== ""){
	                ?>
        <td align="right"><a href="index.php?put=<?=$this->nombre?>_search&abm_accion=s&direccion=up&id=<?=$fila[$this->nombre_id]?>&amp;<?=$this->serializeIt?>" class="arrow"><img src="images/up_arrow-trans.png" border="0" /></a>&nbsp;<a href="index.php?put=<?=$this->nombre?>_search&abm_accion=s&direccion=down&id=<?=$fila[$this->nombre_id]?>&amp;<?=$this->serializeIt?>"  class="arrow"><img src="images/down_arrow-trans.png" border="0" /></a></td>
        <?
	                	}
	                	
	                	if($this->tiene_galeria){
	                ?>
        <td><a href="<?=$href_fotos?>"><img src="images/ico_fotos.gif" alt="Fotos" border="0" /></a></td>
        <?
	                	}
	                	
						foreach($this->botones_columna as $boton){
	                ?>
        <td><?
						  	if($boton["target"] == ""){
		                  ?>
          <a href="javascript:showPopWin('<?=$boton["href_path"]?>?id=<?=$fila[$this->nombre_id]?>', <?=$boton["ancho_ventana"]?>, <?=$boton["alto_ventana"]?>, null)"><img src="<?=$boton["icon_path"]?>" alt="<?=$boton["alt_text"]?>" border="0" /></a>
          <?
						  	}else{
						  ?>
          <a href="<?=$boton["href_path"]?>?id=<?=$fila[$this->nombre_id]?>" target="<?=$boton["target"]?>"><img src="<?=$boton["icon_path"]?>" alt="<?=$boton["alt_text"]?>" border="0" /></a>
          <?
							}
		                  ?></td>
        <?
	                	}

						if(!$this->readOnly){
					?>
        <td><a href="<?=$href_eliminar?>&amp;data_serialize=<?=$temp?>" onclick="return confirmDelete();"><img src="images/ico-delete-trans.png" alt="Borrar" border="0" /></a></td>
        <?
	                	}
	                ?>
      </tr>
      <?
	            }
	            ?>
    </tbody>
  </table>
</div>
<?
		}
	
		private function renderPaginador(){
			
			$result_nro = $this->query($this->consultaPaginador);
			$reg_nro = $this->getRows();
			
			$mostrar_puntos_izq = true;
			
			$ventana = VENTANA;
			$pag_nro = ceil($reg_nro/$this->paginacion);
			$pag_ultima = ceil($reg_nro/$this->paginacion) == $reg_nro ? $reg_nro-1 : ceil($reg_nro/$this->paginacion);
			$pag_actual = ($this->ls + $this->paginacion) / $this->paginacion;
			
			if($pag_actual > floor($ventana / 2)){
				$ventana_li = $pag_actual - floor($ventana / 2);
			}else{
				$ventana_li = 1;
			}
			if($result_nro > $this->paginacion){
			?>
<div class="block">
  <div id="paginador">
    <div id="pagina_actual">P&aacute;gina
      <?=floor($pag_actual)?>
      /
      <?=$pag_nro?>
    </div>
    <div id="controles_paginador">
      <?
				$ventana_ls = $ventana_li + $ventana;
				
				if($this->ls != 0){
					
					$atras = $this->ls - $this->paginacion;
			?>
      <a href="<?=$_SERVER['PHP_SELF'].'?'.$this->parametros_url."&amp;ls=0"?>"><img src="images/paginador/btn_pag_primero.gif" alt="" border="0" align="left" /></a><a href="<?=$_SERVER['PHP_SELF'].'?'.$this->parametros_url."&amp;ls=".$atras?>"><img src="images/paginador/btn_pag_anterior.gif" alt="" border="0" align="left" /></a>
      <?
				}else{
			?>
      <img src="images/paginador/btn_pag_primero_off.gif" alt="" border="0" align="left" /><img src="images/paginador/btn_pag_anterior_off.gif" alt="" border="0" align="left" />
      <?
				}
			?>
      <div id="esquina_izq"><span></span></div>
      <div id="ir_pagina">
        <?
				for($pag = 1; $pag <= $pag_nro; $pag ++){
					
					if($mostrar_puntos_izq && $pag_actual > ceil($ventana/2)){
						
						$mostrar_puntos_izq = false;
			?>
        <div class="puntos">...</div>
        <?
					}
					
					if($pag >= $ventana_li && $pag < $ventana_ls){//VENTANA
						
						$reg_desde = ($pag * $this->paginacion) - $this->paginacion;
						
						if($pag == $pag_actual){ //PAGINA ACTUAL
			?>
        <div class="numeros">
          <?
							
							$array_numeros = str_split($pag);
							
							foreach($array_numeros as $numero){
								?>
          <img src="images/paginador/num_bold_<?=$numero?>.gif" border="0" />
          <?
							}
							
							if($pag != $pag_nro){
							?>
          <img src="images/paginador/palito.gif" alt="" />
          <?
							}
							?>
        </div>
        <?
						}else{
			?>
        <div class="numeros"><a href="<?=$_SERVER['PHP_SELF'].'?'.$this->parametros_url."&amp;ls=".$reg_desde?>">
          <?
							
							$array_numeros = str_split($pag);
							
							foreach($array_numeros as $numero){
								?>
          <img src="images/paginador/num_<?=$numero?>.gif" border="0" />
          <?
							}
							?>
          </a>
          <?
							if($pag != $pag_nro){
							?>
          <img src="images/paginador/palito.gif" alt="" />
          <?
							}
							?>
        </div>
        <?
						}
					}
				}
				
				if($pag_actual <= ($pag_nro - ceil($ventana/2))){
			?>
        <div class="puntos">...</div>
        <?
				}
			?>
      </div>
      <div id="esquina_der"><span></span></div>
      <?
				if($pag_nro > 1 && ($this->ls + $this->paginacion) < ($pag_nro * $this->paginacion)){
					$adelante = $this->ls + $this->paginacion;
			?>
      <a href="<?=$_SERVER['PHP_SELF'].'?'.$this->parametros_url."&amp;ls=".$adelante?>"><img src="images/paginador/btn_pag_siguiente.gif" alt="" border="0" align="left" /></a> <a href="<?=$_SERVER['PHP_SELF'].'?'.$this->parametros_url."&amp;ls=".$pag_ultima?>"><img src="images/paginador/btn_pag_ultimo.gif" alt="" border="0" align="left" /></a>
      <?
				}
			?>
    </div>
  </div>
</div>
<?
			}
		}
	
		public function show(){
			$this->makeDatos();
			$this->renderHeaders();
			$this->renderTitulos();
			if(!$this->readOnly){
				$this->renderSolapas();
			}
		?>
<div id="feed">
  <div id="conteiner_feed_add" style="display: <?=$this->data->get("feed",DATA_EX_TYPE_STR,false) != '' ? "" : "none" ?>">
    <div id="feed_add">
      <div id="text_feed">
        <?
				switch($this->data->get("feed",DATA_EX_TYPE_STR,false)){

					case "a":
						echo "Se agreg&oacute; un registro.";
						break;					
					case "m":
						echo "Se modific&oacute; un registro.";
						break;
					case "d":
						echo "Se borr&oacute; un registro.";
						break;
				}
			?>
      </div>
      <img src="images/ico_info.jpg" alt="" /> </div>
  </div>
</div>
<div class="block"><? $this->renderfiltros(); ?>
<? $this->renderHTML(); ?>
<? $this->renderTablaResultados(); ?></div>
<? $this->renderPaginador();?>
<script type="text/javascript">
//<![CDATA[
	//r.start();
	
	$('#check_all').click(function(){
		$("INPUT[type='checkbox']").attr('checked', $('#check_all').is(':checked'));    
	});
//]]>
</script>
<?
		}
	}
?>
