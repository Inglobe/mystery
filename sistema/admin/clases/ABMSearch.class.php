<?php
class ABMSearch{

	//PARAMETROS
	var $nombre;
	var $tabla;
	var $nombre_id;
	var $categoria;
	var $titulo;
	var $consulta;
	public $readOnly = false;

	//INTERNAS
	private $link_db;
	private $columnas = array();
	private $botones_columna = array();
	private $filtros = array();
	private $datos = array();
	private $relaciones;
	private $orden;
	private $id_tabla = 0;
	private $ls = 0;
	private $paginacion = 0;
	private $parametros_url;
	private $filtrosSQL = "";
	private $nro_registros = 0;
	private $campo_orden = "";
	private $orden_select = "";
	private $tiene_galeria = false;
	private $debug;

	function ABMSearch($linkDB,$nombre,$tabla,$nombre_id,$categoria,$titulo,$consulta,$paginacion=20,$debug=false){

		$this->linkDB = $linkDB;
		$this->nombre = $nombre;
		$this->tabla = $tabla;
		$this->nombre_id = $nombre_id;
		$this->categoria = $categoria;
		$this->titulo = $titulo;
		$this->consulta = $consulta;
		$this->paginacion = $paginacion;
		$this->debug = $debug;

		$string_parametros = "?put=".$this->nombre."_search&amp;show=1";
		foreach($_GET as $parametro => $valor){
			$aux = explode("_",$parametro);
			if($aux[0] == "abm" || $aux[0] == "filtro"){
				$string_parametros .= "&amp;".urlencode($parametro)."=".urlencode($valor);
			}
		}
		$this->parametros_url = $string_parametros;
		if(isset($_GET["ls"])){
			$this->ls = $_GET["ls"];
		}

	}

	public function setCampoOrden($campo,$orden_select = ""){
		$this->campo_orden = $campo;
		$this->orden_select = $orden_select;
	}

	public function setGaleria(){
		$this->tiene_galeria = true;
	}

	public function addCol($campoDB,$campoMostrar,$titulo,$ancho,$tituloAlineacion,$datoAlineacion,$orden=false,$orden_direccion="ASC",$campoMostrarPreTxt="",$campoMostrarPostTxt=""){

		$mat_col["tipo"] = $tipo;
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

	public function addButtonCol($href_path,$icon_path,$alt_text,$ancho_ventana,$alto_ventana){

		$mat_col["href_path"] = $href_path;
		$mat_col["icon_path"] = $icon_path;
		$mat_col["alt_text"] = $alt_text;
		$mat_col["ancho_ventana"] = $ancho_ventana;
		$mat_col["alto_ventana"] = $alto_ventana;

		$this->botones_columna[] = $mat_col;
	}

	public function addFilter($tipo,$campoDB,$label,$ancho=12,$consulta="",$campoMostrar="",$item_ninguno="",$estilo=""){
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

	private function getOrdenSQL($columna=""){

		//crear matriz orden en sesion
		session_register("orden_".$this->nombre);
	 	if(!is_array($_SESSION["orden_".$this->nombre])){
	 		$_SESSION["orden_".$this->nombre] = $this->orden;
	 	}

		$mat_orden = $_SESSION["orden_".$this->nombre];

		$encontrado=false;
		for($i=0;$i<sizeof($mat_orden);$i++){
			if($mat_orden[$i]["campoDB"]==$columna){
				if($i==0){
					if($mat_orden[$i]["direccion"]=="ASC")
						$mat_orden[$i]["direccion"]="DESC";
					else
						$mat_orden[$i]["direccion"]="ASC";
				}
				else{
					$aux[0]["campoDB"]=$mat_orden[$i]["campoDB"];
					$aux[0]["direccion"]=$mat_orden[$i]["direccion"];
					$encontrado=TRUE;
				}
			}
			if($encontrado){
				$mat_orden[$i]["campoDB"]=$mat_orden[$i+1]["campoDB"];
				$mat_orden[$i]["direccion"]=$mat_orden[$i+1]["direccion"];
			}
		}
		if($encontrado){
			$temp=array_pop($mat_orden);
			$mat_orden=array_merge($aux,$mat_orden);
		}
		$salida.= $mat_orden[0]["campoDB"]." ".$mat_orden[0]["direccion"];
		for($i=1;$i<sizeof($mat_orden);$i++){
			$salida.= ", ".$mat_orden[$i]["campoDB"]." ".$mat_orden[$i]["direccion"];
		}

		$_SESSION["orden_".$this->nombre] = $mat_orden;

		return $salida;
	}

	private function ordenarRegistro($id,$direccion,$orden_consulta = ""){

		if($orden_consulta == ""){
			$consulta = "SELECT ".$this->campo_orden.", ".$this->nombre_id." FROM ".$this->tabla." ORDER BY ".$this->campo_orden." ASC";
		}
		else{
			$consulta = $this->consulta." ORDER BY ".$orden_consulta;
		}

		$result = mysql_query($consulta,$this->linkDB);
		echo mysql_error($this->linkDB);

		$nro_registros = mysql_num_rows($result);

		$cont = 0;
		while($fila_tmp=mysql_fetch_assoc($result)){
			$cont++;

			mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".$cont." WHERE ".$this->nombre_id." = ".$fila_tmp[$this->nombre_id],$this->linkDB);
			echo mysql_error($this->linkDB);
		}

		$fila_tmp= mysql_fetch_assoc(mysql_query("SELECT ".$this->campo_orden." FROM ".$this->tabla." WHERE ".$this->nombre_id." = ".$id,$this->linkDB));
		echo mysql_error($this->linkDB);
		$orden_campo_seleccionado = $fila_tmp[$this->campo_orden];

		switch($direccion){
			case "up":
				if($orden_campo_seleccionado > 1){
					$fila_tmp= mysql_fetch_assoc(mysql_query("SELECT ".$this->nombre_id." FROM ".$this->tabla." WHERE ".$this->campo_orden." = ".($orden_campo_seleccionado - 1),$this->linkDB));
					$id_campo_afectado=$fila_tmp[$this->nombre_id];

					mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".($orden_campo_seleccionado - 1)." WHERE ".$this->nombre_id." = ".$id,$this->linkDB);
					echo mysql_error($this->linkDB);

					mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".($orden_campo_seleccionado)." WHERE ".$this->nombre_id." = ".$id_campo_afectado,$this->linkDB);
					echo mysql_error($this->linkDB);
				}
			break;
			case "down":
				if($orden_campo_seleccionado < $nro_registros){
					$fila_tmp= mysql_fetch_assoc(mysql_query("SELECT ".$this->nombre_id." FROM ".$this->tabla." WHERE ".$this->campo_orden." = ".($orden_campo_seleccionado + 1),$this->linkDB));
					$id_campo_afectado=$fila_tmp[$this->nombre_id];

					mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".($orden_campo_seleccionado + 1)." WHERE ".$this->nombre_id." = ".$id,$this->linkDB);
					echo mysql_error($this->linkDB);

					mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".($orden_campo_seleccionado)." WHERE ".$this->nombre_id." = ".$id_campo_afectado,$this->linkDB);
					echo mysql_error($this->linkDB);
				}
			break;
		}
	}

	private function makeDatos(){

		//ordenar registro
		if(isset($_GET["direccion"])){
			$this->ordenarRegistro($_GET["id"],$_GET["direccion"],$this->orden_select);
		}

		//filtros
		foreach($this->filtros as $filtro){
			$valor_tmp = $_GET["filtro_".str_replace(".","",$filtro["campoDB"])];
			switch($filtro["tipo"]){
				case "textField":
					if($valor_tmp != ""){
						$this->filtrosSQL .= "\nAND ".$filtro["campoDB"]." LIKE '%".$valor_tmp."%'";
					}
            	break;
            	case "combo":
            		if($valor_tmp != 0){
						$this->filtrosSQL .= "\nAND ".$filtro["campoDB"]." = ".$valor_tmp;
					}
            	break;
            	case "date":
            		if($_GET["filtro_".$filtro["campoDB"]."_check"]){
						$this->filtrosSQL .= "\nAND ".$filtro["campoDB"]." = '".convertirFechaParaMySQL($valor_tmp)."'";
					}
            	break;
            }
		}

		//consulta DB
		$consulta = $this->consulta;

		if(stripos($consulta, "where") === false && $this->filtrosSQL != ""){
			$consulta .= "\nWHERE 1 = 1";
		}

		$consulta .= $this->filtrosSQL;

		if($this->campo_orden == ""){
			$consulta .= "\nORDER BY ".$this->getOrdenSQL($_GET["campo_ordenar"]);
		}
		else{
			if($this->orden_select == ""){
				$consulta .= "\nORDER BY ".$this->campo_orden;
			}
			else{
				$consulta .= "\nORDER BY ".$this->orden_select;
			}
		}
		$this->consulta = $consulta;

		$consulta .= "\nLIMIT ".$this->ls.",".$this->paginacion;
		
		

		if($this->debug){
			echo "<hr>".$consulta."<hr>";
		}

		$result_consulta = mysql_query($consulta,$this->linkDB);
		echo mysql_error($this->linkDB);

		$this->nro_registros = mysql_num_rows($result_consulta);

		while($fila=mysql_fetch_array($result_consulta)){
			$this->datos[] = $fila;
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
			function checkRelacion(id){
				var tiene_relacion = false;
				<?
				if(is_array($this->relaciones)){
					foreach($this->relaciones as $relacion){
				?>
						var sql = "SELECT COUNT(*) AS NRO FROM <?=$relacion["tabla"]?> WHERE <?=$relacion["campo"]?> = " + id;
						var mysql = new MySQLDatabase();
						mysql.query(sql);
						mysql.nextRow();
						if(mysql.getField("NRO") > 0){
							tiene_relacion=true;
						}
				<?
					}
				}
				?>
				if(tiene_relacion){
					alert("Cannot delete this item.");
					return false;
				}
				else{
					return confirm("Want to delete this item?.")
				}
			}
			function validar(f){
				return true;
			}

		    var r = new Restrict("form_<?=$this->nombre?>");

		    r.onKeyRefuse = function(o, k){
		        o.style.backgroundColor = "#fdc";
		    }
		    r.onKeyAccept = function(o, k){
		        if(k > 30)
		            o.style.backgroundColor = "#ffffff";
		    }
		//]]>
		</script>
		<?
	}

	private function renderTitulos(){
		?>
		<div id="titulo">
	      <h1>
			  <span><?=$this->categoria?></span><span class="separador_tit">/</span><span class="gris"><?=$this->titulo?></span><span class="separador_tit">/</span><span class="gris_claro">Buscar</span>
		  </h1>
	    </div>
		<?
	}

	private function renderSolapas(){
		?>
		  <div id="btns_sup">
		  <?
			if(!$this->readOnly){
		  ?>
		  <a href="index.php?put=<?=$this->nombre?>_am&abm_accion=a"><img src="imagenes/btn_sup_add.jpg" alt="" border="0" /></a>
		  <?
			}
		  ?>
		  </div>
		<?
	}

	private function renderFiltros(){
		require("ABMControls.class.php");

		if(count($this->filtros)>0){
			?>
			<form id="form_<?=$this->nombre?>" name="form_<?=$this->nombre?>" method="get" action="index.php">
	          <fieldset id="campos" >
	          <legend style="display:none;">Filters</legend>
	          <input type="hidden" name="put" value="<?=$this->nombre?>_search" />
	          <input type="hidden" name="abm_filtrar" value="1" />
	        <?
	        foreach($this->filtros as $filtro){
	        	$campoDB_limpio = str_replace(".","",$filtro["campoDB"]);
	        ?>
	          <div class="campo">
	            <label for="id_filtro_<?=$campoDB_limpio?>"><?=$filtro["label"]?>:</label>
				<?
				$valor_tmp = $_GET["filtro_".$campoDB_limpio];
				$control = new ABMControls("filtro_".$campoDB_limpio,"id_filtro_".$campoDB_limpio,"form_".$this->nombre);
				switch($filtro["tipo"]){
					case "textField":
						$control->createTextField($valor_tmp,"\\\\.","",$filtro["ancho"]);
	            	break;
	            	case "combo":
						$control->createCombo($this->linkDB,$filtro["consulta"],$filtro["campoDB"],$filtro["campoMostrar"],$valor_tmp,$filtro["item_ninguno"]);
	            	break;
	            	case "date":
	            		$control = new ABMControls("filtro_".$campoDB_limpio,"id_filtro_".$campoDB_limpio,"form_".$this->nombre,"","",!$_GET["filtro_".$campoDB_limpio."_check"]);
						$control->createDatePicker($valor_tmp,$permitir_nulo=true,$_GET["filtro_".$campoDB_limpio."_check"]);
	            	break;
	            }
	            ?>
	          </div>
			<?
			}
			?>
			  </fieldset>
	          <div id="btns_ok_cancel"><a href="index.php"><img src="imagenes/btn_all.jpg" alt="" hspace="5" border="0" /></a><input type="image" src="imagenes/btn_search.jpg" alt="" border="0" /></div>
			</form>
			<?
		}
	}

	private function renderTablaResultados(){
		?>
		<div id="tabla">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" id="tabla_search">
              <thead>
			    <tr>
			<?
			foreach($this->columnas as $columna){
			?>
                  <th width="<?=$columna["ancho"]?>" align="<?=$columna["tituloAlineacion"]?>">
				<?
				if(is_array($_SESSION["orden_".$this->nombre])){
					$i_orden=0;
					foreach($_SESSION["orden_".$this->nombre] as $orden){
						$i_orden++;
						if($columna["campoDB"] == $orden["campoDB"]){
				?>
					<a href="<?=$PHP_SELF.$this->parametros_url."&amp;campo_ordenar=".$columna["campoDB"]?>"><?=$columna["titulo"]?>
					 	<img src="imagenes/flecha_<?=($orden["direccion"]=="ASC"?"arriba":"abajo")?>_blanca_<?=($i_orden==1)?"on":"off"?>.gif" alt="" hspace="5" border="0"/>
					</a>
				<?
						}
					}
					reset($this->orden);
				}
				else{
					echo $columna["titulo"];
				}
				?>
				  </th>
			<?
			}
			?>
				<?
				if($this->campo_orden !== ""){
					$col_orden = 1;
                ?>
                  <th width="1%">&nbsp;</th>
                <?
                }
                else{
					$col_orden = 0;
				}
				if($this->tiene_galeria){
					$col_galeria = 1;
                ?>
                  <th width="1%">&nbsp;</th>
                <?
                }
                else{
					$col_galeria = 0;
				}
				foreach($this->botones_columna as $boton){
                ?>
                  <th width="1%">&nbsp;</th>
                <?
                }
                ?>
				<?
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
            		<td  colspan="<?=count($this->columnas)+1+$col_orden+$col_galeria?>" class="lista_clara" align="center">No data.</td>
				</tr>
            <?
            }
			foreach($this->datos as $fila){
				$estilo_fila=($estilo_fila=="lista_clara"?"lista_oscura":"lista_clara");
				$href_modificar="index.php?put=".$this->nombre."_am&id=".$fila[$this->nombre_id]."&abm_accion=m";
				$href_eliminar="index.php?put=".$this->nombre."_procesar&id=".$fila[$this->nombre_id]."&abm_accion=d";
				$href_fotos="javascript:MM_openBrWindow('gallery_pop.php?id_relacion=".$fila[$this->nombre_id]."&nombre_abm=".$this->nombre."','','width=850,height=530')";
            ?>
                <tr class="<?=$estilo_fila?>">
                <?
                foreach($this->columnas as $columna){
                ?>
                  <td align="<?=$columna["datoAlineacion"]?>">
				  	<?
					if(!$this->readOnly){
					?>
				  	<a href="<?=$href_modificar?>">
					<?
					}
					?>
					<?=$columna["campoMostrarPreTxt"].$fila[$columna["campoMostrar"]].$columna["campoMostrarPostTxt"]?>
					<?
					if(!$this->readOnly){
					?>
					</a>
					<?
					}
					?></td>
                <?
                }
				if($this->campo_orden !== ""){
                ?>
                  <td>
				  	<?
					if(!$this->readOnly){
					?>
				  	<a href="index.php?direccion=up&id=<?=$fila[$this->id_tabla]?>">
					<?
					}
					?>
					  <img src="imagenes/flecha_arriba.gif" border="0" />
					<?
					if(!$this->readOnly){
					?>
					</a>
					<?
					}
					?>
					&nbsp;
					<?
					if(!$this->readOnly){
					?>
					<a href="index.php?direccion=down&id=<?=$fila[$this->id_tabla]?>">
					<?
					}
					?>
					  <img src="imagenes/flecha_abajo.gif" border="0" />
					<?
					if(!$this->readOnly){
					?>
					</a>
					<?
					}
					?>
				  </td>
                <?
                }
                if($this->tiene_galeria){
                ?>
                  <td><a href="<?=$href_fotos?>"><img src="imagenes/ico_fotos.gif" alt="Fotos" border="0" /></a></td>
                <?
                }
				foreach($this->botones_columna as $boton){
                ?>
                  <td><a href="javascript:showPopWin('<?=$boton["href_path"]?>?id=<?=$fila[$this->id_tabla]?>', <?=$boton["ancho_ventana"]?>, <?=$boton["alto_ventana"]?>, null)"><img src="<?=$boton["icon_path"]?>" alt="<?=$boton["alt_text"]?>" border="0" /></a></td>
                <?
                }
				if(!$this->readOnly){
                ?>
                  <td><a href="<?=$href_eliminar?>" onclick="return checkRelacion(<?=$fila[$this->id_tabla]?>);" class="btn_delete" id="<?=$this->tabla."_".$fila[$this->id_tabla]?>"><img src="imagenes/ico_delete.gif" alt="Borrar" border="0" /></a></td>
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
					$result_nro = mysql_query($this->consulta,$this->linkDB);
					$reg_nro=0;
					$mostrar_puntos_izq=true;
					while($fila=mysql_fetch_array($result_nro)){
						$reg_nro++;
					}
					$ventana=7;
					$pag_nro=ceil($reg_nro/$this->paginacion);
					$pag_actual=($this->ls+$this->paginacion)/$this->paginacion;
					$ultima_pag_ls = ($pag_nro-1)*$this->paginacion;
					if($pag_actual > floor($ventana/2)){
						$ventana_li=$pag_actual - floor($ventana/2);
					}
					else{
						$ventana_li=1;
					}
				?>
				<div id="contenedor_paginador">
				  <div id="paginador">
				    <div id="pagina_actual">P&aacute;gina <?=floor($pag_actual)?>/<?=$pag_nro?></div>
				    <div id="controles_paginador">
				<?
					$ventana_ls=$ventana_li+$ventana;
					if($this->ls!=0){
						$atras=$this->ls-$this->paginacion;
				?>
					<a href="<?=$PHP_SELF.$this->parametros_url."&amp;ls=0"?>"><img src="imagenes/paginador/btn_pag_primero.gif" alt="" border="0" align="left" /></a><a href="<?=$PHP_SELF.$this->parametros_url."&amp;ls=".$atras?>"><img src="imagenes/paginador/btn_pag_anterior.gif" alt="" border="0" align="left" /></a>
				<?
					}
					else{
				?>
					<img src="imagenes/paginador/btn_pag_primero_off.gif" alt="" border="0" align="left" /><img src="imagenes/paginador/btn_pag_anterior_off.gif" alt="" border="0" align="left" />
				<?
					}
				?>
					<div id="esquina_izq"><span></span></div>
					<div id="ir_pagina">
				<?
					for($pag=1;$pag<=$pag_nro;$pag++){
						if($mostrar_puntos_izq && $pag_actual > ceil($ventana/2)){
							$mostrar_puntos_izq=false;
				?>
						<div class="puntos">...</div>
				<?
						}
						if($pag >= $ventana_li && $pag < $ventana_ls){//VENTANA
							$reg_desde=($pag*$this->paginacion)-$this->paginacion;
							if($pag==$pag_actual){ //PAGINA ACTUAL
				?>
								<div class="numeros">
								<?
								$array_numeros = str_split($pag);
								foreach($array_numeros as $numero){
									?><img src="imagenes/paginador/num_bold_<?=$numero?>.gif" border="0" /><?
								}
								if($pag!=$pag_nro){
								?><img src="imagenes/paginador/palito.gif" alt="" /><?
								}
								?></div>
				<?
							}
							else{
				?>
								<div class="numeros"><a href="<?=$PHP_SELF.$this->parametros_url."&amp;ls=".$reg_desde?>"><?
								$array_numeros = str_split($pag);
								foreach($array_numeros as $numero){
									?><img src="imagenes/paginador/num_<?=$numero?>.gif" border="0" /><?
								}
								?></a><?
								if($pag!=$pag_nro){
								?><img src="imagenes/paginador/palito.gif" alt="" /><?
								}
								?></div>
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
					if($pag_nro > 1 && ($this->ls+$this->paginacion) < ($pag_nro*$this->paginacion)){
						$adelante=$this->ls+$this->paginacion;
				?>
					<a href="<?=$PHP_SELF.$this->parametros_url."&amp;ls=".$adelante?>"><img src="imagenes/paginador/btn_pag_siguiente.gif" alt="" border="0" align="left" /></a><a href="<?=$PHP_SELF.$this->parametros_url."&amp;ls=".$ultima_pag_ls?>"><img src="imagenes/paginador/btn_pag_ultimo.gif" alt="" border="0" align="left" /></a>
				<?
					}
				?>
				    </div>
				  </div>
				</div>
		<?
	}

	public function show(){
		$this->makeDatos();
		$this->renderHeaders();
		$this->renderTitulos();
		$this->renderSolapas();
	?>

	<div id="feed">
	<div id="contenedor_feed_add" style="display: <?=isset($_GET["feed"])?"":"none"?>">
	  <div id="feed_add">
		<div id="texto_feed"><?
	          	  switch($_GET["feed"]){
	          	  	  case "m":
	          	  	  	  echo "Se modific&oacute; un registro.";
	          	  	  break;
	          	  	  case "d":
	          	  	  	  echo "Se borr&oacute; un registro.";
	          	  	  break;
				  }
			  ?></div><img src="imagenes/ico_info.jpg" alt="" />
	  </div>
	</div>
	</div>
	<div id="filtros">
  <div class="cbza_bloque">
    <div class="cont_fondo_bloque_sup_izq">
      <div class="fondo_bloque_sup_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_sup_der">
      <div class="fondo_bloque_sup_der"><span></span></div>
    </div>
  </div>
  <div class="borde_bloque_izq">
    <div class="borde_bloque_der">
      <div class="cuerpo_bloque">
		<?
		$this->renderFiltros();
		?>
    </div>
    </div>
  </div>
  <div class="pie_bloque">
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div class="fondo_bloque_inf_der"><span></span></div>
    </div>
  </div>
</div>
<div id="lista">
  <div class="cbza_bloque_lista">
    <div class="cont_fondo_bloque_sup_izq">
      <div class="fondo_bloque_sup_izq_lista"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_sup_der">
            <div class="fondo_bloque_sup_der_lista"><span></span></div>
          </div>
  </div>
  <div class="borde_bloque_izq">
    <div class="borde_bloque_der">
      <div class="cuerpo_bloque_lista">
		<?
		$this->renderTablaResultados();
		?>
      </div>
    </div>
  </div>
  <div class="pie_bloque_lista">
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq_lista"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div class="fondo_bloque_inf_der_lista"><span></span></div>
    </div>
  </div>
</div>
<div class="bloque_sin_degrade">
  <div class="cbza_bloque_sin_degrade">
    <div class="cont_fondo_bloque_sup_izq">
      <div class="fondo_bloque_sup_izq_sin_degrade"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_sup_der">
      <div class="fondo_bloque_sup_der_sin_degrade"><span></span></div>
    </div>
  </div>
  <div class="borde_bloque_izq">
    <div class="borde_bloque_der">
      <div class="cuerpo_bloque_sin_degrade">
<?=$this->renderPaginador()?>
</div>
    </div>
  </div>
  <div class="pie_bloque">
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div class="fondo_bloque_inf_der"><span></span></div>
    </div>
  </div>
</div>
    <script type="text/javascript">
	//<![CDATA[
	    r.start();
	//]]>
	</script>
		<?
	}
}
?>