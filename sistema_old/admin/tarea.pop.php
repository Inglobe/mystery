<?
	require("procesos_globales.php");

	if($_SESSION["id_usr"] == null){
		?>
		<script type="text/javascript">
		<!--
			setTimeout('parent.recargar()', 1000);
			setTimeout('parent.hidePopWin()', 1000);
		//-->
		</script>
		<?
		die("No esta logueado al sistema!");
	}

	$consulta_proyectos = "SELECT 		*
							FROM 		proyectos
							WHERE 		id_proyecto = ".$_GET["id_proyecto"];
	$fila_proyecto=mysql_fetch_assoc(mysql_query($consulta_proyectos,$link));

	if(isset($_GET["id_tarea"])){//modificar
		$consulta_tarea = "SELECT 			*,
											DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%Y') AS fecha_ie_f,
											DATE_FORMAT(fecha_inicio_real,'%d/%m/%Y') AS fecha_ir_f,
											DATE_FORMAT(fecha_fin_estimada,'%d/%m/%Y') AS fecha_fe_f,
											DATE_FORMAT(fecha_fin_real,'%d/%m/%Y') AS fecha_fr_f,
											DATE_FORMAT(fecha_modificacion,'%d/%m/%Y') AS fecha_m_f
							FROM 			tareas
							WHERE 			id_tarea = ".$_GET["id_tarea"];
		$fila_tarea = mysql_fetch_assoc(mysql_query($consulta_tarea,$link));
		echo mysql_error($link);

		mysql_query("DELETE FROM usuarios_notificaciones WHERE id_usuario = ".$_SESSION["id_usr"]." AND id_tarea = ".$_GET["id_tarea"],$link);
		echo mysql_error($link);
	}
	else{//cargar valores por defecto
		if($_GET["id_padre"] == 0){//busca valores en el proyecto
			$fila_tmp_default = mysql_fetch_assoc(mysql_query("SELECT 	DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%Y') AS fecha_ie_f
																		, DATE_FORMAT(fecha_fin_estimada,'%d/%m/%Y') AS fecha_fe_f
																		, id_usuario_responsable
																FROM 	proyectos
																WHERE 	id_proyecto = ".$_GET["id_proyecto"],$link));
		}
		else{//busca valores en la tarea padre
			$fila_tmp_default = mysql_fetch_assoc(mysql_query("SELECT 	DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%Y') AS fecha_ie_f
																		, DATE_FORMAT(fecha_fin_estimada,'%d/%m/%Y') AS fecha_fe_f
																		, id_usuario_responsable
																		, id_tipo_tarea
																FROM 	tareas
																WHERE 	id_tarea = ".$_GET["id_padre"],$link));
		}
		echo mysql_error($link);

		$fila_tarea["fecha_ie_f"]=$fila_tmp_default["fecha_ie_f"];
		$fila_tarea["fecha_fe_f"]=$fila_tmp_default["fecha_fe_f"];
		$fila_tarea["id_usuario_responsable"]=$fila_tmp_default["id_usuario_responsable"];
		$fila_tarea["id_tipo_tarea"]=$fila_tmp_default["id_tipo_tarea"];
		$fila_tarea["id_prioridad_tarea"] = 2;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 0px;
	padding-left: 10px;
}
-->
</style>
<link href="clases/ABMControls/datePicker/styles/fsdateselect.css" rel="stylesheet" type="text/css" />
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_library/prototype.js"></script>
<script type="text/javascript" src="../includes/funciones_generales.js"></script>
<script type="text/javascript" src="js_library/multi_file_upload.js"></script>
<script type="text/javascript" src="../includes/MySQLDatabase.class.js"></script>
<script type="text/javascript" src="clases/ABMControls/datePicker/scripts/fsdateselect.js"></script>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><h1><span class="gris">Proyectos</span><span class="separador_tit">/</span><span class="gris"><?=$fila_proyecto["nombre"]?></span><span class="separador_tit">/</span><span class="gris_claro">Tarea</span></h1></title>
</head>
<body>
<?
if(isset($_GET["id_tarea"])){
	$fila_cliente_tmp = mysql_fetch_assoc(mysql_query("SELECT * FROM clientes WHERE id_cliente = ".$fila_proyecto["id_cliente"]." LIMIT 1",$link));
?>
<div style="padding-bottom:10px;"><strong><?=$fila_cliente_tmp["nombre"]?></strong> / <?=getTareasPadres($_GET["id_tarea"])?></div>
<?
}
?>
<form id="form_agregar_tarea" name="form_agregar_tarea" method="post" action="tarea_feed.pop.php?id_proyecto=<?=$_GET["id_proyecto"]?><?=(isset($_GET["id_tarea"])?"&amp;id_tarea=".$_GET["id_tarea"]:"")?>" enctype="multipart/form-data">
  <input type="hidden" value="<?=$_GET["id_padre"]?>" name="id_tarea_padre" />
  <input type="hidden" value="<?=$_GET["orden"]?>" name="orden" />
  <input type="hidden" value="<?=$_SESSION["id_usr"]?>" name="id_usuario_tarea" id="id_usuario_tarea" />
  <div id="filtros"  style="padding-bottom: 5px;">
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
        <div class="cuerpo_bloque" style="padding-right:0px;">
		<div class="campo">
            <label for="cmb_id_usuario_responsable"><strong>Autor</strong>:</label>
            <div style="padding-top:4px; float:left;"><?
  	if(isset($_GET["id_tarea"])){
		echo getUsrNomById($fila_tarea["id_usuario_owner"]);
	}
	else {
		echo $_SESSION["usr_nombre"];
  	}
  ?></div>
          </div>
          <div class="campo">
            <label for="cmb_id_usuario_responsable">Responsable:</label>
            <select name="id_usuario_responsable" id="cmb_id_usuario_responsable">
              <option value="0">--seleccione--</option>
              <?
				$consulta_usr = "SELECT * FROM usuarios ORDER BY nombre ASC";
				$result_usr = mysql_query($consulta_usr,$link);
				echo mysql_error($link);
				while($fila_usr = mysql_fetch_assoc($result_usr)){
			?>
              <option value="<?=$fila_usr["id_usuario"]?>" <?=($fila_usr["id_usuario"]==$fila_tarea["id_usuario_responsable"]?"selected=\"selected\"":"")?>>
              <?=$fila_usr["nombre"]?>
              </option>
              <?
				}
			?>
            </select>
          </div>
          <div class="campo">
            <label for="cmb_id_tipo_tarea">Tipo de tarea:</label>
            <select name="id_tipo_tarea" id="cmb_id_tipo_tarea">
              <option value="0">--seleccione--</option>
              <?
				$consulta_tt = "SELECT * FROM tipos_tarea ORDER BY descripcion ASC";
				$result_tt = mysql_query($consulta_tt,$link);
				echo mysql_error($link);
				while($fila_tt = mysql_fetch_assoc($result_tt)){
			?>
              <option value="<?=$fila_tt["id_tipo_tarea"]?>" <?=($fila_tt["id_tipo_tarea"]==$fila_tarea["id_tipo_tarea"]?"selected=\"selected\"":"")?>>
              <?=$fila_tt["descripcion"]?>
              </option>
              <?
				}
			?>
            </select>
          </div>
          <div class="campo">
            <label for="cmb_id_prioridad_tarea">Prioridad:</label>
            <select name="id_prioridad_tarea" id="cmb_id_prioridad_tarea">
              <option value="0">--seleccione--</option>
              <?

				$consulta_pt = "SELECT * FROM prioridades_tarea ORDER BY id_prioridad_tarea ASC";
				$result_pt = mysql_query($consulta_pt,$link);
				echo mysql_error($link);
				while($fila_pt = mysql_fetch_assoc($result_pt)){
			?>
              <option value="<?=$fila_pt["id_prioridad_tarea"]?>" <?=($fila_pt["id_prioridad_tarea"]==$fila_tarea["id_prioridad_tarea"]?"selected=\"selected\"":"")?>>
              <?=$fila_pt["descripcion"]?>
              </option>
              <?
				}
			?>
            </select>
          </div>
          <div class="campo">
            <label for="fecha_inicio_estimada" style="float:left; margin-top:4px; margin-right:4px;">Inicio estimado:</label>
            <script type="text/javascript">
			// <![CDATA[
			<?
				if(empty($fila_tarea["fecha_ie_f"])){
					$fecha = getdate();
					$fecha_from = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"];
				}else{
					$fecha_from = $fila_tarea["fecha_ie_f"];
				}
			?>
			  FSfncWriteFieldHTML("form_agregar_tarea","fecha_inicio_estimada","<?=$fecha_from?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
			// ]]>
		  	</script>
          </div>
          <div class="campo">
            <label for="fecha_fin_estimada" style="float:left; margin-top:4px; margin-right:4px;">Fin estimado:</label>
            <script type="text/javascript">
			// <![CDATA[
			<?
				if(empty($fila_tarea["fecha_fe_f"])){
					$fecha = getdate();
					$fecha_to = $fecha["mday"]."/".$fecha["mon"]."/".$fecha["year"];
				}else{
					$fecha_to = $fila_tarea["fecha_fe_f"];
				}
			?>
			  FSfncWriteFieldHTML("form_agregar_tarea","fecha_fin_estimada","<?=$fecha_to?>","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
			// ]]>
		  	</script>
          </div>
		  <?
		  	if(isset($_GET["id_tarea"])){
				if($fila_tarea["fecha_ir_f"]!="00/00/0000"){
		  ?>
		  <div class="campo" style="width:120px;">
		  	<label>Inicio real:</label> <label><?=$fila_tarea["fecha_ir_f"]?></label>
		  </div>
		  <?
		  		}
				if($fila_tarea["fecha_fr_f"]!="00/00/0000"){
		  ?>
		  <div class="campo" style="width:110px;">
		  	<label>Fin real:</label> <label><?=$fila_tarea["fecha_fr_f"]?></label>
		  </div>
		  <?
		  		}
				?>
		  <? if($fila_tarea["fecha_m_f"]!="00/00/0000"){
		  ?>
		  <div class="campo" style="margin-bottom:0px; width:160px;">
		  	<label>&Uacute;ltima modificacion:</label> <label><?=$fila_tarea["fecha_m_f"]?></label>
		  </div>
		  <?
		  		}
		  ?>
		  <?
		  	}
		  ?>
		  <div class="campo" style="margin-bottom:0px;">
		  	<label for="check_notificar">Notificar</label><input type="checkbox" id="check_notificar" name="notificar" value="1"  />
		  </div>
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
  <div id="lista"  style="padding-bottom: 5px;">
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
        	<div style="width: 370px; float: left;">
	          <div class="control">
	            <div class="label_add" style="float: none; text-align: left">
	              <label for="descripcion"> Descripci&oacute;n: </label>
	            </div>
	            <input type="text" name="descripcion" id="descripcion" value="<?=xhtmlOut($fila_tarea["descripcion"])?>" style="width: 350px;" />
	          </div>
	          <div class="control" style="padding-bottom:0px;">
	            <div class="label_add" style="float: none; text-align: left">
	              <label for="obs">Observaciones: </label>
	            </div>
	            <textarea name="obs" id="obs" style="width: 350px; height:65px;"><?=$fila_tarea["obs"]?></textarea>
	          </div>
	        </div>
	        <div style="width: 225px; float: left;">
	          <div class="control">
	            <div class="label_add" style="float: none; text-align: left">
	              <label for="obs">Archivos: </label>
	            </div>
	            <input type="file" name="multifile" id="multifile" />
	            <div style="padding-top: 10px; height: 50px; overflow: auto;">
	              <ul id="file_list"><?
			$ruta="../downloads/tareas/";

	        if(isset($_GET["id_archivo_eliminar"])){
				$fila_tmp_archivo=mysql_fetch_array(mysql_query("SELECT archivo FROM archivos_tarea WHERE id_archivo_tarea = ".$_GET["id_archivo_eliminar"],$link));
				unlink($ruta.$fila_tmp_archivo["archivo"]);

				mysql_query("DELETE FROM archivos_tarea WHERE id_archivo_tarea = ".$_GET["id_archivo_eliminar"],$link);
				echo mysql_error($link);
			}

			$result_archivos = mysql_query("SELECT * FROM archivos_tarea WHERE id_tarea = ".$_GET["id_tarea"],$link);
			if($result_archivos){
				while($fila_archivo=mysql_fetch_assoc($result_archivos)){
			?>
                  <li><a href="<?=$ruta.rawurlencode($fila_archivo["archivo"])?>" target="_blank">
                    <?=$fila_archivo["archivo"]?> - <?=ceil((filesize($ruta.$fila_archivo["archivo"])/1024))."Kb"?>
                    </a>
                    <a href="tarea.pop.php?id_archivo_eliminar=<?=$fila_archivo["id_archivo_tarea"]?>&id_tarea=<?=$_GET["id_tarea"]?>&id_padre=<?=$_GET["id_padre"]?>&id_proyecto=<?=$_GET["id_proyecto"]?>" onClick="return confirm('Esta seguro de borrar el archivo?')"><img src="imagenes/ico_delete.gif" border="0" class="tachito"/></a></li>
                  <?
				}
			}
			    ?></ul>
			    </div>
	          </div>
	        </div>
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
  <div class="bloque_sin_degrade"  style="padding-bottom: 5px;">
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
		  <div style="width: 100%; float: left; position: relative;">
          <? /*<div class="campo" style="margin-bottom:0px;">
            <label>Estado:</label>
          </div> */ ?>

        <?
		$tiene_hijos = false;
		if(isset($_GET["id_tarea"])){
			if(tiene_hijos($_GET["id_tarea"])){
				$tiene_hijos = true;
			}
		}
		else{
			$fila_tarea["id_estado_tarea"] = 1;
		}
		if($tiene_hijos){
			$fila_et = mysql_fetch_assoc(mysql_query("SELECT descripcion FROM estados_tarea WHERE id_estado_tarea = ".$fila_tarea["id_estado_tarea"],$link));
			echo mysql_error($link);
		?>
		<div class="campo" style="margin-bottom:0px;">
		  <label for="id_estado_tarea_<?=$fila_tarea["id_estado_tarea"]?>" style="float: none"><img src="imagenes/estado_tarea_<?=$fila_tarea["id_estado_tarea"]?>.gif" alt="" />
			<?=$fila_et["descripcion"]?>
		  </label>
		</div>
		  <?
		}
		else {
		?>
        <div class="campos" style="float:left; width:170px;">
        <?
			$consulta_et = "SELECT * FROM estados_tarea ORDER BY id_estado_tarea ASC";
			$result_et = mysql_query($consulta_et,$link);
			echo mysql_error($link);
			while($fila_et = mysql_fetch_assoc($result_et)){
		?>
          <div class="campo" style="margin-bottom:0px;float:none;">
			<input type="radio" name="id_estado_tarea" id="id_estado_tarea_<?=$fila_et["id_estado_tarea"]?>" value="<?=$fila_et["id_estado_tarea"]?>" <?=($fila_et["id_estado_tarea"]==$fila_tarea["id_estado_tarea"]?"checked=\"checked\"":"")?> size="80" />
			<label for="id_estado_tarea_<?=$fila_et["id_estado_tarea"]?>" style="float: none"><img src="imagenes/estado_tarea_<?=$fila_et["id_estado_tarea"]?>.gif" alt="" />
			<?=$fila_et["descripcion"]?>
			</label>
		  </div>
		<?
			}
		?>
        </div>
        <?
		}
		?>
		<?
		if(isset($_GET["id_tarea"])){
			if(!$tiene_hijos){
		?>
        <div class="campos" style="float:left; width:280px;" >
		  <div class="campo" style="margin-bottom:0px;">
          	<div>
                <label for="tiempo" style="float:left; margin-top:2px; margin-right:4px; display:block; width:130px;">Tiempo real:</label>
                <input type="text" name="tiempo" id="tiempo" value="<?=$fila_tarea["tiempo"]?>" style="width: 20px;" /> mins.
			</div>
            <div>
                <label for="tiempo_estimado" style="float:left; margin-top:2px; margin-right:4px; display:block; width:130px;">Tiempo estimado:</label>
                <input type="text" name="tiempo_estimado" id="tiempo_estimado" value="<?=$fila_tarea["tiempo_estimado"]?>" style="width: 20px;" /> mins.
			</div>
            <div>
                <label for="tiempo_presupuestado" style="float:left; margin-top:2px; margin-right:4px; display:block; width:130px;">Tiempo presupuestado:</label>
                <input type="text" name="tiempo_presupuestado" id="tiempo_presupuestado" value="<?=$fila_tarea["tiempo_presupuestado"]?>" style="width: 20px;" /> mins.
            </div>
          </div>
        </div>
		<label for="cmb_conformidad">Conformidad:</label>
		<select name="id_conformidad" id="cmb_conformidad">
		<?
		$consulta_conf = "SELECT * FROM conformidad ORDER BY id_conformidad ASC";
		$result_conf = mysql_query($consulta_conf,$link);
		echo mysql_error($link);
		while($fila_conf = mysql_fetch_assoc($result_conf)){
		?>
		  <option value="<?=$fila_conf["id_conformidad"]?>" <?=($fila_conf["id_conformidad"]==$fila_tarea["id_conformidad"]?'selected="selected"':'')?>><?=xhtmlOut($fila_conf["descripcion"])?></option>
		<?
		}
		?>
		</select>
		<?
			}
		}else{
			if(!$tiene_hijos){
		?>
		  <div class="campo" style="margin-bottom:0px;">
          	<div>
                <label for="tiempo_estimado" style="float:left; margin-top:2px; margin-right:4px; display:block; width:120px;">Tiempo estimado:</label>
                <input type="text" name="tiempo_estimado" id="tiempo_estimado" value="<?=$fila_tarea["tiempo_estimado"]?>" style="width: 20px;" /> mins.
            </div>
            <div>
                <label for="tiempo_presupuestado" style="float:left; margin-top:2px; margin-right:4px; display:block; width:120px;">Tiempo presupuestado:</label>
                <input type="text" name="tiempo_presupuestado" id="tiempo_presupuestado" value="<?=$fila_tarea["tiempo_presupuestado"]?>" style="width: 20px;" /> mins.
            </div>
          </div>
		<?
			}
		}
		?>
			
		  </div>
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
  <?
if(isset($_GET["id_tarea"])){
  ?>
  <div id="lista"  style="padding-bottom: 5px;">
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
      <div class="cuerpo_bloque_lista" style="position: relative;  padding-top: 15px; background-color:#F4F4F4;">
	    <div class="campo" style="position: absolute; top:0px; left:5px;"><strong>Comentarios:</strong></div>
	    <?
		if(isset($_GET["id_tarea"])){
	    ?>
		<div class="campo" style="position: absolute; top:0px; right:-5px;"><a href="#" id="agregar_log" rel="<?=$_GET["id_tarea"]?>"><img src="imagenes/btn_agregar_comentario.gif" alt="" width="30" height="16" /></a></div>
	    <?
		}
	    ?>
        <div id="tabla" style="height:80px; overflow:auto; background-color:#F4F4F4;">
          <? include ("logs_tareas.inc.php")?>
        </div>
      </div>
    </div>
  </div>
  <div class="pie_bloque_lista" >
    <div class="cont_fondo_bloque_inf_izq">
      <div class="fondo_bloque_inf_izq_lista"><span></span></div>
    </div>
    <div class="cont_fondo_bloque_inf_der">
      <div class="fondo_bloque_inf_der_lista"><span></span></div>
    </div>
  </div>
</div>
<?
}
?>
 <? /* <div class="bloque_sin_degrade" style="padding-bottom: 0px;">
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
        <div class="cuerpo_bloque">*/ ?>
          <div id="btns_ok_cancel"><a href="#" id="btn_cancel"><img src="imagenes/btn_cancel.jpg" alt="" border="0" /></a>
            <input type="image" src="imagenes/btn_ok.jpg" alt="" hspace="5" border="0" />
          </div>
    <? /*    </div>
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
  </div> */ ?>
</form>
<script type="text/javascript" src="js_library/tarea_pop.js"></script>
</body>
</html>
