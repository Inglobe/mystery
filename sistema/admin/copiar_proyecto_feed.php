<?php
	include("procesos_globales.php");

	$fila_pag = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM clientes WHERE activo = 1", $link));
	$nro_registros = $fila_pag["nro"];

	$paginacion = 100;
	$ls = (isset($_GET["ls"])?$_GET["ls"]:0);
	$ls_prox = $ls + $paginacion;

	/*$_POST["anio"] = 2009;
	$_POST["mes"] = 01;*/

	$fecha_ie = $_GET["anio"]."-".$_GET["mes"]."-"."01";

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT id_usuario, LAST_DAY('".$fecha_ie."') AS anio FROM usuarios WHERE supervisor = 1", $link));
	echo mysql_error($link);
	$fecha_fe = $fila_tmp["anio"];
	$id_usuario_supervisor = $fila_tmp["id_usuario"];

	switch($_GET["mes"]){
		case 01:
			$mes_r = "Enero";
		break;
		case 02:
			$mes_r = "Febrero";
		break;
		case 03:
			$mes_r = "Marzo";
		break;
		case 04:
			$mes_r = "Abril";
		break;
		case 05:
			$mes_r = "Mayo";
		break;
		case 06:
			$mes_r = "Junio";
		break;
		case 07:
			$mes_r = "Julio";
		break;
		case 08:
			$mes_r = "Agosto";
		break;
		case 09:
			$mes_r = "Septiembre";
		break;
		case 10:
			$mes_r = "Octubre";
		break;
		case 11:
			$mes_r = "Noviembre";
		break;
		case 12:
			$mes_r = "Diciembre";
		break;
	}

	$consulta_clientes = "	SELECT
								c.*
								, l.id_usuario_responsable AS responsable_localidad
							FROM
								clientes c
								, tipos_clientes tc
								, localidades l
							WHERE
								c.id_tipo_cliente = tc.id_tipo_cliente
								AND c.id_localidad = l.id_localidad
								AND activo = 1
							LIMIT ".$ls.",".$paginacion."
						 ";
	$result_clientes = mysql_query($consulta_clientes, $link);
	echo mysql_error($link);

	while($fila_cliente = mysql_fetch_assoc($result_clientes)){

		$consulta_templates = "SELECT * FROM proyectos WHERE id_tipo_proyecto = ".$fila_cliente["id_tipo_cliente"]." AND template = 1";
		$result_templates = mysql_query($consulta_templates, $link);
		echo mysql_error($link);
		while($fila_template = mysql_fetch_assoc($result_templates)){
			$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM proyectos WHERE descripcion LIKE '%Relevamiento ".$mes_r." - ".$_GET["anio"].$fila_template["titulo_escondido"]."%' AND id_cliente = '".$fila_cliente["id_cliente"]."'",$link));
			if($fila_tmp["nro"] == 0){
				$insert_proy = "INSERT INTO
									proyectos (
										nombre
										, id_cliente
										, id_tipo_proyecto
										, id_usuario_responsable
										, id_usuario_supervisor
										, fecha_inicio_estimada
										, fecha_fin_estimada
										, fecha_entrega_estimada
										, fecha_alta
										, id_estado_proyecto
										, id_condicion
									)
									VALUES (
										'Relevamiento ".$mes_r." - ".$_GET["anio"].$fila_template["titulo_escondido"]."'
										, '".$fila_cliente["id_cliente"]."'
										, '".$fila_cliente["id_tipo_cliente"]."'
										, '".$fila_cliente["responsable_localidad"]."'
										, '".$id_usuario_supervisor."'
										, '".$fecha_ie."'
										, '".$fecha_fe."'
										, '".$fecha_fe."'
										, NOW()
										, 1
										, 1
									)";
				mysql_query($insert_proy, $link);
				echo mysql_error($link);
				$id_proyecto = mysql_insert_id($link);
		
				$consulta = "SELECT
									*
									, DAY(fecha_inicio_estimada) AS dia_fecha_ie
									, DAY(fecha_fin_estimada) AS dia_fecha_fe
								FROM
									tareas
								WHERE
									id_proyecto = ".$fila_template["id_proyecto"];
				$result = mysql_query($consulta, $link);
				echo mysql_error($link);
		
				$indice_mat = 0;
				while($fila = mysql_fetch_assoc($result)){
					//echo $_POST["anio"]."-".$_POST["mes"]."-".$fila["dia_fecha_ie"];
					$insert = "INSERT INTO
									tareas (
										descripcion
										, id_prioridad_tarea
										, orden
										, fecha_alta
										, fecha_inicio_estimada
										, fecha_fin_estimada
										, detalle
										, id_estado_tarea
										, id_usuario_owner
										, id_usuario_responsable
										, id_tipo_tarea
										, obs
										, id_proyecto
										, invertir
									)
									VALUES (
										'".$fila["descripcion"]."'
										, '".$fila["id_prioridad_tarea"]."'
										, '".$fila["orden"]."'
										, NOW()
										, '".$_GET["anio"]."-".$_GET["mes"]."-".$fila["dia_fecha_ie"]."'
										, '".$fecha_fe."'
										, '".$fila["detalle"]."'
										, '".$fila["id_estado_tarea"]."'
										, '".$fila["id_usuario_owner"]."'
										, '".$fila_cliente["responsable_localidad"]."'
										, '".$fila["id_tipo_tarea"]."'
										, '".$fila["obs"]."'
										, '".$id_proyecto."'
										, '".$fila["invertir"]."'
									)
							   ";
					mysql_query($insert, $link);
		
					$matriz_ids[$indice_mat]["id_nuevo"] = mysql_insert_id($link);
					$matriz_ids[$indice_mat]["id_viejo"] = $fila["id_tarea"];
					$matriz_ids[$indice_mat]["id_viejo_padre"] = $fila["id_tarea_padre"];
		
					$indice_mat++;
				}
		
				//print_r($matriz_ids);
		
				for($i=0;$i<$indice_mat;$i++){
					if($matriz_ids[$i]["id_viejo_padre"] != 0){
						for($j=0;$j<$indice_mat;$j++){
							if($matriz_ids[$j]["id_viejo"] == $matriz_ids[$i]["id_viejo_padre"]){
								mysql_query("UPDATE tareas SET id_tarea_padre = ".$matriz_ids[$j]["id_nuevo"]." WHERE id_tarea = ".$matriz_ids[$i]["id_nuevo"],$link);
								echo mysql_error($link);
							}
						}
					}
				}
			}
		}
	}
?>
<div id="contenedor_loading">
  <div id="loading">Generando tareas, espere por favor...<br /> Esta operacion puede tardar varios minutos.<br /><font color="red">NO CORTE EL PROCESO, NO ACTUALIZE NI SALGA DE ESTA PANTALLA.</font><br />El proceso terminara solo.<br />
  <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script language="JavaScript">
<!--
<?
	if($ls<$nro_registros){
?>
  		setTimeout('redireccionar("index.php?put=copiar_proyecto_feed&ls=<?=$ls_prox?>&anio=<?=$_GET["anio"]?>&mes=<?=$_GET["mes"]?>")', 3000);
<?
	}
	else{
?>
  		setTimeout('redireccionar("index.php?put=copiar_proyecto_feed_ok")', 3000);
<?
	}
?>
//-->
</script>