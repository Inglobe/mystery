<?
	require("procesos_globales.php");
	$fila_cliente=mysql_fetch_assoc(mysql_query("SELECT * FROM clientes WHERE id_cliente = ".$_GET["id_cliente"],$link));
	$consulta_proyectos = "SELECT 		*,
										DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%y') AS fecha_ie_f,
										DATE_FORMAT(fecha_inicio_real,'%d/%m/%y') AS fecha_ir_f,
										DATE_FORMAT(fecha_fin_estimada,'%d/%m/%y') AS fecha_fp_f,
										DATE_FORMAT(fecha_fin_real,'%d/%m/%y') AS fecha_fr_f,
										DATE_FORMAT(fecha_entrega_estimada,'%d/%m/%y') AS fecha_ee_f,
										DATE_FORMAT(fecha_entrega_real,'%d/%m/%y') AS fecha_er_f
							FROM 		proyectos
							WHERE 		id_proyecto = ".$_GET["id_proyecto"];
	$fila_proyecto=mysql_fetch_assoc(mysql_query($consulta_proyectos,$link));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Zephia Administration System</title>
<link href="css_library/tareas.print.css" rel="stylesheet" type="text/css" />
<link href="css_library/estilos.print.css" rel="stylesheet" type="text/css" />
<link href="css_library/cuerpo.print.css" rel="stylesheet" type="text/css" />
</head>
<body onload="window.print()">
<script type="text/javascript">
<!--
	function ocultar_tarea(id_tarea){

	}
	function MM_openBrWindow(theURL,winName,features) { //v2.0

	}
//-->
</script>
<div id="proyecto"><img src="imagen.php?ruta=../imagenes/clientes/logos/<?=rawurlencode($fila_cliente["logo"])?>&amp;ancho=454&amp;alto=337&amp;mantener_ratio=1&amp;franjas=1" alt="<?=$fila_cliente["nombre"]?>" name="logo" width="109" height="81" border="0" id="logo"/>
  <div id="datos_usuario">
    <div id="fecha_usuario"><strong>Fecha de impresi&oacute;n:</strong>
      <?=date("d/m/Y",time())?>
      <br />
      <strong>Usuario:</strong>
      <?=$_SESSION["usr_nombre"]?>
    </div>
    <?
		$fila_user = mysql_fetch_assoc(mysql_query("SELECT * FROM usuarios WHERE id_usuario = ".$_SESSION["id_usr"],$link));
		if($fila_user["foto"]!=""){
			$foto_str = "imagen.php?ruta=../imagenes/usuarios/fotos/".$fila_user["foto"]."&amp;ancho=51&amp;alto=50&mantener_ratio=1";
		}
		else{
			$foto_str = "imagenes/user_default.jpg";
		}
	?>
    <img src="<?=$foto_str?>" alt="" width="51" height="50" vspace="10" /><br />
  </div>
  <div style="clear:both; padding-top:10px;">
    <div id="columna_proyecto_top">
      <div id="columna_proyecto_top_contenido">
        <div id="tit_proyecto_top">
          <div class="fujiyama_proyecto"><strong>
            <?=$fila_proyecto["nombre"]?>
            </strong></div>
        </div>
        <div id="datos_proyecto"><img src="imagenes/ico_torta_grande.jpg" alt="" id="ico_torta_proyecto" />
          <div id="estado_proyecto"><strong>Estado:</strong> En proceso (<span class="texto_azul"><strong>
            <?=avance_ponderado($fila_proyecto["id_proyecto"])?>
            %</strong></span>)</div>
          <div id="fechas_proyectos">
            <div class="dato_label_proyecto">Inicio:<strong> previsto <?=$fila_proyecto["fecha_ie_f"]?>&nbsp;&nbsp;|&nbsp;&nbsp;real <?=($fila_proyecto["fecha_ir_f"]=="00/00/00"?"No iniciado":$fila_proyecto["fecha_ir_f"])?></strong></div>
            <div class="dato_label_proyecto">Fin:<strong> previsto <?=$fila_proyecto["fecha_ie_f"]?>&nbsp;&nbsp;|&nbsp;&nbsp;real <?=($fila_proyecto["fecha_fr_f"]=="00/00/00"?"No finalizado":$fila_proyecto["fecha_fr_f"])?></strong></div>
            <div class="dato_label_proyecto">Entrega:<strong> previsto <?=$fila_proyecto["fecha_ee_f"]?>&nbsp;&nbsp;|&nbsp;&nbsp;real <?=($fila_proyecto["fecha_er_f"]=="00/00/00"?"No finalizado":$fila_proyecto["fecha_er_f"])?></strong></div>
            <?
					$horas_calc = getHorasProyectos($fila_proyecto["id_proyecto"]);
				?>
            <div class="dato_label_proyecto"> Horas:<strong>
              <?=($horas_calc < $fila_proyecto["horas_estimadas"] ? $horas_calc : "<span style=\"color: #FF0000\">".$horas_calc."</span>") ?>
              /
              <?=$fila_proyecto["horas_estimadas"]?>
              hs.</strong></div>
          </div>
          <?
				include("proyecto_usuarios.inc.php");
			?>
        </div>
        <div style="clear:both;"><span></span></div>
      </div>
    </div>
  </div>
  <div id="tareas">
      <div id="tareas_contenido">
        <?
		function mostrar_tarea($id_padre, $id_proyecto, $nivel){
			global $link;
			global $_SESSION;

			$cadena="SELECT 		*,
									DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%y') AS fecha_f,
									DATE_FORMAT(fecha_fin_estimada,'%d/%m/%y') AS fecha_f_f
						FROM 		tareas
						WHERE 		id_tarea_padre = ".$id_padre."
						AND 		id_proyecto = ".$id_proyecto."
						ORDER BY	orden
					";
			$result = mysql_query($cadena,$link);
			echo mysql_error($link);

			$orden = 0;
			while ($fila = mysql_fetch_array($result)) {
				$tiene_hijos = tiene_hijos($fila["id_tarea"]);
		?>
        <div class="tarea_<?=$nivel?>" id="tarea_<?=$fila["id_tarea"]?>">
          <?
				require("tarea.inc.print.php");
				mostrar_tarea($fila["id_tarea"], $id_proyecto, $nivel+1);
		?>
        </div>
        <?
				$orden++;
			}
		}

		$fila_tarea = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM tareas WHERE id_proyecto = ".$_GET["id_proyecto"]." AND id_tarea_padre = 0 ORDER BY orden ASC",$link));
		echo mysql_error($link);

		if($fila_tarea["nro"]>0){
			mostrar_tarea(0, $_GET["id_proyecto"], 0);
		}
	?>
      </div>
    </div>
  <div id="pie_print"><img src="imagenes/logo_pie.gif" alt="" width="49" height="14" style="float:right;" />Zephia Administration System</div>
  
</div>

</body>
</html>
