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
	private $consultaPaginador;
	private $orden;
	private $id_tabla = 0;
	private $ls = 0;
	private $paginacion = 0;
	private $parametros_url;
	private $filtrosSQL = "";
	private $nro_registros = 0;
	private $campo_orden = "";
	private $tiene_galeria = false;
	private $debug;
	private $addedHTML = "";

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

		$string_parametros = "?show=1";
		foreach($_GET as $parametro => $valor){
			$aux = explode("_",$parametro);
			//if($aux[0] == "abm" || $aux[0] == "filtro" || $aux[0] == "put"){
				$string_parametros .= "&amp;".urlencode($parametro)."=".urlencode($valor);
			//}
		}
		$this->parametros_url = $string_parametros;
		if(isset($_GET["ls"])){
			$this->ls = $_GET["ls"];
		}

	}

	public function setCampoOrden($campo){
		$this->campo_orden = $campo;
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

	public function addHTML($codigo){
		$this->addedHTML[] = $codigo;
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

	private function ordenarRegistro($id,$direccion,$consulta = ""){

		if($consulta == ""){
			$consulta = "SELECT ".$this->campo_orden." FROM ".$this->tabla;
		}

		$consulta .= " ORDER BY ".$this->campo_orden." ASC";

		$result = mysql_query($consulta,$link);
		echo mysql_error($link);

		$nro_registros = mysql_num_rows($result);

		$cont = 0;
		while($fila_tmp=mysql_fetch_assoc($result)){
			$cont++;

			mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".$cont." WHERE ".$this->nombre_id." = ".$fila_tmp[$this->nombre_id],$link);
			echo mysql_error($link);
		}

		$fila_tmp= mysql_fetch_assoc(mysql_query("SELECT ".$this->campo_orden." FROM ".$this->tabla." WHERE ".$this->nombre_id." = ".$id,$link));
		echo mysql_error($link);
		$orden_campo_seleccionado = $fila_tmp[$this->campo_orden];

		switch($direccion){
			case "up":
				if($orden_campo_seleccionado > 1){
					$fila_tmp= mysql_fetch_assoc(mysql_query("SELECT ".$this->nombre_id." FROM ".$this->tabla." WHERE ".$this->campo_orden." = ".($orden_campo_seleccionado - 1),$link));
					$id_campo_afectado=$fila_tmp[$id_nombre];

					mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".($orden_campo_seleccionado - 1)." WHERE ".$this->nombre_id." = ".$id,$link);
					echo mysql_error($link);

					mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".($orden_campo_seleccionado)." WHERE ".$this->nombre_id." = ".$id_campo_afectado,$link);
					echo mysql_error($link);
				}
			break;
			case "down":
				if($orden_campo_seleccionado < $nro_registros){
					$fila_tmp= mysql_fetch_assoc(mysql_query("SELECT ".$this->nombre_id." FROM ".$this->tabla." WHERE ".$this->campo_orden." = ".($orden_campo_seleccionado + 1),$link));
					$id_campo_afectado=$fila_tmp[$id_nombre];

					mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".($orden_campo_seleccionado + 1)." WHERE ".$this->nombre_id." = ".$id,$link);
					echo mysql_error($link);

					mysql_query("UPDATE ".$this->tabla." SET ".$this->campo_orden." = ".($orden_campo_seleccionado)." WHERE ".$this->nombre_id." = ".$id_campo_afectado,$link);
					echo mysql_error($link);
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
			$consulta .= "\nORDER BY ".$this->campo_orden." ASC";
		}

		$this->consultaPaginador = $consulta;

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
						resultado = MYSQL2XML("SELECT COUNT(*) AS NRO FROM <?=$relacion["tabla"]?> WHERE <?=$relacion["campo"]?> = " + id);
						var item = resultado.getElementsByTagName('fila')[0];
						if(item.getElementsByTagName('NRO')[0].firstChild.data!=0){
							tiene_relacion=true;
						}
				<?
					}
				}
				?>
				if(tiene_relacion){
					alert("No se puede borrar el registro.\nEst� relacionado con otros datos.");
					return false;
				}
				else{
					return confirm("Esta seguro de borrar el registro?")
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
		<div id="solapas">
		<?
		if(!$this->readOnly){
		?>
		  <div id="solapa_add"><a href="index.php?put=<?=$this->nombre?>_am&abm_accion=a"><img src="skins/gris/es/solapa_agregar_off.gif" alt="Agregar" border="0" /></a></div>
		<?
		}
		?>
		  <div id="solapa_search"><img src="skins/gris/es/solapa_buscar_on.gif" alt="Buscar" border="0" /></div>
		</div>
		<?
	}

	private function renderHTML(){
		if(is_array($this->addedHTML)){
			foreach($this->addedHTML as $html){
				echo $html;
			}
		}
	}

	private function renderFiltros(){
		require("ABMControls.class.php");

		if(count($this->filtros)>0){
			?>
			<form id="form_<?=$this->nombre?>" name="form_<?=$this->nombre?>" method="get" action="index.php">
	          <fieldset id="campos" >
	          <legend style="display:none;">Filtros</legend>
	          <input type="hidden" name="put" value="<?=$this->nombre?>_search" />
	          <input type="hidden" name="abm_filtrar" value="1" />
	        <?
	        foreach($this->filtros as $filtro){
	        	$campoDB_limpio = str_replace(".","",$filtro["campoDB"]);
	        ?>
	          <div id="campo">
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
	          <div id="botones"><a href="index.php?put=<?=$_GET["put"]?>"><img src="skins/gris/es/btn_todos.gif" alt="" hspace="5" border="0" /></a> <input type="image" src="skins/gris/es/btn_filtrar.gif" alt="" border="0" /></div>
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
				$i_orden=0;
				foreach($_SESSION["orden_".$this->nombre] as $orden){
					$i_orden++;
					if($columna["campoDB"] == $orden["campoDB"]){
				?>
					<a href="<?=$PHP_SELF.$this->parametros_url."&amp;campo_ordenar=".$columna["campoDB"]?>"><?=$columna["titulo"]?>
					 	<img src="skins/gris/imagenes/flecha_<?=($orden["direccion"]=="ASC"?"arriba":"abajo")?>_blanca_<?=($i_orden==1)?"on":"off"?>.gif" alt="flecha" width="7" height="5" hspace="5" border="0"/>
					</a>
				<?
					}
				}
				reset($this->orden);
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
              <tfoot>
                <tr>
                  <td colspan="<?=count($this->columnas)+1+$col_orden+$col_galeria+count($this->botones_columna)?>"><?=$this->renderPaginador()?></td>
                </tr>
              </tfoot>
              <tbody>
			<?
			if(count($this->datos) == 0){
            ?>
            	<tr>
            		<td  colspan="<?=count($this->columnas)+1+$col_orden+$col_galeria?>" class="lista_clara" align="center">No se encontraron registros.</td>
				</tr>
            <?
            }
			foreach($this->datos as $fila){
				$estilo_fila=($estilo_fila=="lista_clara"?"lista_oscura":"lista_clara");
				$href_modificar="index.php?put=".$this->nombre."_am&id=".$fila[$this->nombre_id]."&abm_accion=m";
				$href_eliminar="index.php?put=".$this->nombre."_procesar&id=".$fila[$this->nombre_id]."&abm_accion=d";
				$href_fotos="javascript:MM_openBrWindow('gallery_pop.php?id_relacion=".$fila[$this->nombre_id]."&nombre_abm=".$this->nombre."','','width=913,height=606')";
            ?>
                <tr>
                <?
                foreach($this->columnas as $columna){
                ?>
                  <td class="<?=$estilo_fila?>" align="<?=$columna["datoAlineacion"]?>"><?
                  if(!$this->readOnly){
				  ?><a href="<?=$href_modificar?>"><?
				  }
				  ?><?=$columna["campoMostrarPreTxt"].$fila[$columna["campoMostrar"]].$columna["campoMostrarPostTxt"]?><?
                  if(!$this->readOnly){
				  ?></a><?
				  }
				  ?></td>
                <?
                }
				if($this->campo_orden !== ""){
                ?>
                  <td class="<?=$estilo_fila?>"><a href="index.php?direccion=up&id=<?=$fila[$this->id_tabla]?>"><img src="imagenes/flecha_arriba.gif" border="0" /></a>&nbsp;<a href="index.php?direccion=down&id=<?=$fila[$this->id_tabla]?>"><img src="imagenes/flecha_abajo.gif" border="0" /></a></td>
                <?
                }
                if($this->tiene_galeria){
                ?>
                  <td class="<?=$estilo_fila?>"><a href="<?=$href_fotos?>"><img src="imagenes/ico_fotos.gif" alt="Fotos" border="0" /></a></td>
                <?
                }
				foreach($this->botones_columna as $boton){
                ?>
                  <td class="<?=$estilo_fila?>"><a href="javascript:MM_openBrWindow('<?=$boton["href_path"]?>?id=<?=$fila[$this->id_tabla]?>','','scrollbars=yes,width=<?=$boton["ancho_ventana"]?>,height=<?=$boton["alto_ventana"]?>')"><img src="<?=$boton["icon_path"]?>" alt="<?=$boton["alt_text"]?>" border="0" /></a></td>
                <?
                }
                ?>
                <?
				if(!$this->readOnly){
				?>
                  <td class="<?=$estilo_fila?>"><a href="<?=$href_eliminar?>" onclick="return checkRelacion(<?=$fila[$this->id_tabla]?>);"><img src="imagenes/ico_delete.gif" alt="Borrar" border="0" /></a></td>
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
		?>
			<ul class="paginador">

				<?
					$result_nro = mysql_query($this->consultaPaginador,$this->linkDB);
					$reg_nro=0;
					$mostrar_puntos_izq=true;
					while($fila=mysql_fetch_array($result_nro)){
						$reg_nro++;
					}
					$ventana=7;
					$pag_nro=ceil($reg_nro/$this->paginacion);
					$pag_actual=($this->ls+$this->paginacion)/$this->paginacion;
					if($pag_actual > floor($ventana/2)){
						$ventana_li=$pag_actual - floor($ventana/2);
					}
					else{
						$ventana_li=1;
					}
					$ventana_ls=$ventana_li+$ventana;
					if($this->ls!=0){
						$atras=$this->ls-$this->paginacion;
				?>
					<li class="paginador_item"><a href="<?=$PHP_SELF.$this->parametros_url."&amp;ls=".$atras?>">&lt;</a></li>
				<?
					}
					for($pag=1;$pag<=$pag_nro;$pag++){
						if($mostrar_puntos_izq && $pag_actual > ceil($ventana/2)){
							$mostrar_puntos_izq=false;
				?>
					<li class="paginador_item">...</li>
				<?
						}
						if($pag >= $ventana_li && $pag < $ventana_ls){//VENTANA
							$reg_desde=($pag*$this->paginacion)-$this->paginacion;
							if($pag==$pag_actual){ //PAGINA ACTUAL
				?>
					<li class="paginador_item_actual"><?=$pag?></li>
				<?
							}
							else{
				?>
					<li class="paginador_item"><a href="<?=$PHP_SELF.$this->parametros_url."&amp;ls=".$reg_desde?>"><?=$pag?></a></li>
				<?
							}
						}
					}
					if($pag_actual <= ($pag_nro - ceil($ventana/2))){
				?>
					<li class="paginador_item">...</li>
				<?
					}
					if($pag_nro > 1 && ($this->ls+$this->paginacion) < ($pag_nro*$this->paginacion)){
						$adelante=$this->ls+$this->paginacion;
				?>
					<li class="paginador_item"><a href="<?=$PHP_SELF.$this->parametros_url."&amp;ls=".$adelante?>">&gt;</a></li>
				<?
					}
				?>
				</ul>
		<?
	}

	public function show(){
		$this->makeDatos();
		$this->renderHeaders();
		$this->renderHTML();
		$this->renderTitulos();
		$this->renderSolapas();

	?>

	<div id="contenedor_feed" style="display: <?=isset($_GET["feed"])?"":"none"?>">
	  <div id="feed">
	    <table border="0" cellspacing="0" cellpadding="0">
	      <tr>
	        <td width="16" align="left" valign="middle"><img src="imagenes/ico_info.gif" alt="" width="10" height="11" /></td>
	        <td><?
	          	  switch($_GET["feed"]){
	          	  	  case "m":
	          	  	  	  echo "Se modific� un registro.";
	          	  	  break;
	          	  	  case "d":
	          	  	  	  echo "Se borr� el registro.";
	          	  	  break;
				  }
			  ?></td>
	      </tr>
	    </table>
	  </div>
	</div>
	<div id="contenido">
	  <div id="recuadro">
		<?
		$this->renderFiltros();
		$this->renderTablaResultados();
		?>
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