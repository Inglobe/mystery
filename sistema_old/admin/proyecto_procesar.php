<?
	if($_GET["finalizar"] != 1){
		if(isset($_POST["id_proyecto"])){
			$consulta = "UPDATE proyectos SET
							nombre = '".$_POST["nombre"]."',
							id_cliente = '".$_POST["id_cliente"]."',
							id_contacto_responsable = '".$_POST["id_contacto_responsable"]."',
							id_tipo_proyecto = '".$_POST["id_tipo_proyecto"]."',
							id_usuario_supervisor = '".$_POST["id_usuario_supervisor"]."',
							id_usuario_responsable = '".$_POST["id_usuario_responsable"]."',
							id_usuario_externo = '".$_POST["id_usuario_externo"]."',
							fecha_inicio_estimada = '".convertirFechaParaMySQL($_POST["fecha_inicio_estimada"])."',
							fecha_fin_estimada = '".convertirFechaParaMySQL($_POST["fecha_fin_estimada"])."',
							fecha_entrega_estimada = '".convertirFechaParaMySQL($_POST["fecha_entrega_estimada"])."',
							obs = '".$_POST["obs"]."',
							archivo_nro = '".$_POST["archivo_nro"]."',
							url_test = '".$_POST["url_test"]."',
							url_final = '".$_POST["url_final"]."',
							path_server_local = '".$_POST["path_server_local"]."',
							id_hosting = '".$_POST["id_hosting"]."',
							horas_estimadas = '".$_POST["horas_estimadas"]."',
							monto_haber = '".$_POST["monto_haber"]."',
							monto_debe = '".$_POST["monto_debe"]."'
						WHERE id_proyecto = ".$_POST["id_proyecto"]."
						";
			mysql_query($consulta,$link);
			echo mysql_error($link);
		}
		else {
			$consulta = "INSERT INTO proyectos (
								nombre
								, id_cliente
								, id_contacto_responsable
								, id_tipo_proyecto
								, id_usuario_supervisor
								, id_usuario_responsable
								, id_usuario_externo
								, fecha_inicio_estimada
								, fecha_fin_estimada
								, fecha_entrega_estimada
								, fecha_alta
								, id_estado_proyecto
								, obs
								, archivo_nro
								, url_test
								, url_final
								, path_server_local
								, id_hosting
								, horas_estimadas
								, monto_haber
								, monto_debe
							)
							VALUES (
								'".$_POST["nombre"]."'
								, '".$_POST["id_cliente"]."'
								, '".$_POST["id_contacto_responsable"]."'
								, '".$_POST["id_tipo_proyecto"]."'
								, '".$_POST["id_usuario_supervisor"]."'
								, '".$_POST["id_usuario_responsable"]."'
								, '".$_POST["id_usuario_externo"]."'
								, '".convertirFechaParaMySQL($_POST["fecha_inicio_estimada"])."'
								, '".convertirFechaParaMySQL($_POST["fecha_fin_estimada"])."'
								, '".convertirFechaParaMySQL($_POST["fecha_entrega_estimada"])."'
								, NOW()
								, 1
								, '".$_POST["obs"]."'
								, '".$_POST["archivo_nro"]."'
								, '".$_POST["url_test"]."'
								, '".$_POST["url_final"]."'
								, '".$_POST["path_server_local"]."'
								, '".$_POST["id_hosting"]."'
								, '".$_POST["horas_estimadas"]."'
								, '".$_POST["monto_haber"]."'
								, '".$_POST["monto_debe"]."'
							)
						";
			mysql_query($consulta,$link);
			echo mysql_error($link);
			$id_nuevo = mysql_insert_id($link);
			enviarMailProyecto($id_nuevo,array($_POST["id_usuario_responsable"],$_POST["id_usuario_supervisor"]));
			$fila_tipo = mysql_fetch_assoc(mysql_query("SELECT id_tipo_tarea FROM tipos_tarea LIMIT 1",$link));
			$consulta_tareas =  "INSERT INTO tareas (
									id_tarea_padre
									, descripcion
									, id_prioridad_tarea
									, fecha_alta
									, fecha_inicio_estimada
									, fecha_fin_estimada
									, id_estado_tarea
									, id_usuario_owner
									, id_usuario_responsable
									, id_tipo_tarea
									, id_proyecto
									)
								VALUES (
									'0'
									, 'Tarea de inicio'
									, '2'
									, NOW()
									, '".convertirFechaParaMySQL($_POST["fecha_inicio_estimada"])."'
									, '".convertirFechaParaMySQL($_POST["fecha_fin_estimada"])."'
									, '1'
									, '".$_POST["id_usuario_supervisor"]."'
									, '".$_POST["id_usuario_responsable"]."'
									, '".$fila_tipo["id_tipo_tarea"]."'
									, '".$id_nuevo."'
									)
								";
			mysql_query($consulta_tareas,$link);
			echo mysql_error($link);
		}
	}
	else {
		if(isset($_GET["id_proyecto"])){
			$consulta = "UPDATE proyectos SET
							id_estado_proyecto = 3
						WHERE id_proyecto = ".$_GET["id_proyecto"]."
						";
			mysql_query($consulta,$link);
			echo mysql_error($link);
		}
	}
?>
<div id="contenedor_loading">
  <div id="loading">Please Wait...<br />
  <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script type="text/javascript">
// <![CDATA[
	<?
		if(isset($_POST["id_proyecto"])){
	?>
	setTimeout('redireccionar("index.php?put=proyectos_search")', 1500);
	<?
		}
		else {
	?>
	setTimeout('redireccionar("index.php?put=proyecto_am")', 1500);
	<?
		}
	?>
// ]]>
</script>