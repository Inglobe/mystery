<?
	if($_GET["finalizar"] != 1){
		if(isset($_POST["id_proyecto"])){
			//actualizar proyecto
		
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
							monto_debe = '".$_POST["monto_debe"]."',
							id_sucursal = '".$_POST["id_sucursal"]."'
						WHERE id_proyecto = ".$_POST["id_proyecto"]."
						";
			mysql_query($consulta,$link);
			echo mysql_error($link);
			
			$id_nuevo = $_POST["id_proyecto"];
			$id_cliente = $_POST["id_cliente"];
		}
		else {
			//proyecto nuevo
		
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
								, id_sucursal
								, plantilla
								, id_plantilla_base
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
								, '".$_POST["id_sucursal"]."'
								, '".$_POST["check_plantilla"]."'
								, '".$_POST["id_plantilla"]."'
							)
						";
			mysql_query($consulta,$link);
			echo mysql_error($link);
			
			$id_nuevo = mysql_insert_id($link);
			
			enviarMailProyecto($id_nuevo,array($_POST["id_usuario_responsable"],$_POST["id_usuario_supervisor"]));
			
			if(!empty($_POST["id_plantilla"])){
				//copiar desde plantilla
				
				$consulta = "SELECT
									*
									, DAY(fecha_inicio_estimada) AS dia_fecha_ie
									, DAY(fecha_fin_estimada) AS dia_fecha_fe
								FROM
									tareas
								WHERE
									id_proyecto = ".$_POST["id_plantilla"];

				$result = mysql_query($consulta, $link);
				echo mysql_error($link);
		
				$indice_mat = 0;
				while($fila = mysql_fetch_assoc($result)){

					$insert = "INSERT INTO
									tareas (
										descripcion
										, id_prioridad_tarea
										, orden
										, fecha_alta
										, fecha_inicio_estimada
										, fecha_fin_estimada
										, id_estado_tarea
										, id_usuario_owner
										, id_usuario_responsable
										, id_tipo_tarea
										, obs
										, detalle
										, leyenda
										, id_proyecto
										, tiempo
										, tiempo_estimado
									)
									VALUES (
										'".$fila["descripcion"]."'
										, '".$fila["id_prioridad_tarea"]."'
										, '".$fila["orden"]."'
										, NOW()
										, '".$_GET["anio"]."-".$_GET["mes"]."-".$fila["dia_fecha_ie"]."'
										, '".$fecha_fe."'
										, '".$fila["id_estado_tarea"]."'
										, '".$_POST["id_usuario_supervisor"]."'
										, '".$_POST["id_usuario_responsable"]."'
										, '".$fila["id_tipo_tarea"]."'
										, '".$fila["obs"]."'
										, '".$fila["detalle"]."'
										, '".$fila["leyenda"]."'
										, '".$id_nuevo."'
										, '".$fila["tiempo"]."'
										, '".$fila["tiempo_estimado"]."'
									)
							   ";
					mysql_query($insert, $link);
					echo mysql_error($link);
					
					$matriz_ids[$indice_mat]["id_nuevo"] = mysql_insert_id($link);
					$matriz_ids[$indice_mat]["id_viejo"] = $fila["id_tarea"];
					$matriz_ids[$indice_mat]["id_viejo_padre"] = $fila["id_tarea_padre"];
		
					$indice_mat++;
					
					$fila_responsable = mysql_fetch_assoc(mysql_query("SELECT email FROM usuarios WHERE id_usuario = ".$_GET["id_usuario_responsable"]." LIMIT 1"));
					
					ob_start();
					require("mails/mail_confirmacion_shopper.php");
					$html = ob_get_contents();
					ob_end_clean();
		
					mail_html($fila_responsable["email"],"website@mysterysur.com.ar","Mystery Sur",$fila_parametros["email_contactenos"],"Confirmación de instrucciones",$html,strip_tags($html));
					
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
			else{
				//crear tarea de inicio
				$fila_tipo = mysql_fetch_assoc(mysql_query("SELECT id_tipo_tarea FROM tipos_tarea LIMIT 1",$link));
				$consulta_tareas =  "INSERT INTO 
										tareas (
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
	}
	else {
		//finalizar proyecto
		if(isset($_GET["id_proyecto"])){
			$consulta = "UPDATE proyectos SET
							id_estado_proyecto = 3
						WHERE id_proyecto = ".$_GET["id_proyecto"]."
						";
			mysql_query($consulta,$link);
			echo mysql_error($link);
			$id_nuevo = $_GET["id_proyecto"];
			$id_cliente = $_GET["id_cliente"];
			
			$fila_auditoria = mysql_fetch_assoc(mysql_query("SELECT nombre, id_cliente FROM proyectos WHERE id_proyecto = ".$_GET["id_proyecto"]." LIMIT 1"));
			$fila_cliente = mysql_fetch_assoc(mysql_query("SELECT email FROM clientes WHERE id_cliente = ".$fila_auditoria["id_cliente"]." LIMIT 1"));

			ob_start();
			require("mails/mail_auditoria_finalizada.php");
			$html = ob_get_contents();
			ob_end_clean();

			mail_html($fila_cliente["email"],"website@mysterysur.com.ar","Mystery Sur",$fila_parametros["email_contactenos"],"Auditoría finalizada",$html,strip_tags($html));
		}
	}
?>
<div id="contenedor_loading">
  <div id="loading">Please Wait...<br />
  <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script type="text/javascript">
// <![CDATA[
	setTimeout('redireccionar("index.php?put=proyecto&id_proyecto=<?=$id_nuevo?>&id_cliente=<?=$id_cliente?>")', 1500);
// ]]>
</script>