<?
	require("procesos_globales.php");

if(!isset($_POST["ocultar"])){
	$_POST["ocultar"] = 0;
}

if($_POST["descripcion"] == "" || $_SESSION["id_usr"] == null){
	?>
	<script type="text/javascript">
	<!--
		setTimeout('parent.recargar()', 1000);
		setTimeout('parent.hidePopWin()', 1000);
	//-->
	</script>
	<?
	die("No se recibieron las variables o no esta logueado al sistema!");
}

if($_SESSION["id_usr"] != NULL){
	if(isset($_GET["id_tarea"])){
		$consulta = "UPDATE 		tareas
						SET  		id_usuario_responsable = '".$_POST["id_usuario_responsable"]."'
									, descripcion = '".$_POST["descripcion"]."'
									, id_prioridad_tarea = '".$_POST["id_prioridad_tarea"]."'
									, fecha_modificacion = NOW()
									, fecha_inicio_estimada = '".convertirFechaParaMySQL($_POST["fecha_inicio_estimada"])."'
									, fecha_fin_estimada = '".convertirFechaParaMySQL($_POST["fecha_fin_estimada"])."'
									, id_estado_tarea = '".$_POST["id_estado_tarea"]."'
									, id_tipo_tarea = '".$_POST["id_tipo_tarea"]."'
									, obs = '".$_POST["obs"]."'
									, detalle = '".$_POST["detalle"]."'
									, ocultar = ".$_POST["ocultar"]."
									, obs_proceso = '".$_POST["obs_proceso"]."'
									, obs_fin = '".$_POST["obs_fin"]."'
									, tiempo = '".$_POST["tiempo"]."'
									, tiempo_estimado = '".$_POST["tiempo_estimado"]."'
									, tiempo_presupuestado = '".$_POST["tiempo_presupuestado"]."'
									, id_conformidad = '".$_POST["id_conformidad"]."'
									, leyenda = '".$_POST["leyenda"]."'
					WHERE			id_tarea = '".$_GET["id_tarea"]."'
		";
		mysql_query($consulta,$link);
		echo mysql_error($link);

		$id_nuevo = $_GET["id_tarea"];
	}
	else {
		//orden las tareas
		if(isset($_POST["orden"])){
			$orden = $_POST["orden"];
			$orden++;
		}
		else{
			$orden=1;
		}
		$cadena="UPDATE tareas SET orden = (orden + 1) WHERE id_tarea_padre = ".$_POST["id_tarea_padre"]." AND orden > ".$orden;
		mysql_query($cadena,$link);

		//inserta en la tabla
		$consulta = "INSERT INTO	tareas (
							id_tarea_padre
							, descripcion
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
							, ocultar
							, obs_proceso
							, obs_fin
							, id_proyecto
							, tiempo
							, tiempo_estimado
							, tiempo_presupuestado
							, id_conformidad
							, leyenda
						)
					VALUES			(
							'".$_POST["id_tarea_padre"]."'
							, '".$_POST["descripcion"]."'
							, '".$_POST["id_prioridad_tarea"]."'
							, '".$orden."'
							, NOW()
							, '".convertirFechaParaMySQL($_POST["fecha_inicio_estimada"])."'
							, '".convertirFechaParaMySQL($_POST["fecha_fin_estimada"])."'
							, '".$_POST["id_estado_tarea"]."'
							, '".$_SESSION["id_usr"]."'
							, '".$_POST["id_usuario_responsable"]."'
							, '".$_POST["id_tipo_tarea"]."'
							, '".$_POST["obs"]."'
							, '".$_POST["detalle"]."'
							, ".$_POST["ocultar"]."
							, '".$_POST["obs_proceso"]."'
							, '".$_POST["obs_fin"]."'
							, '".$_GET["id_proyecto"]."'
							, '".$_POST["tiempo"]."'
							, '".$_POST["tiempo_estimado"]."'
							, '".$_POST["tiempo_presupuestado"]."'
							, '".$_POST["id_conformidad"]."'
							, '".$_POST["leyenda"]."'
						)
					";
		mysql_query($consulta,$link);
		echo mysql_error($link);

		$id_nuevo = mysql_insert_id($link);
	}

	foreach($_FILES as $archivo){
		if($archivo["name"]!=""){
			$aux=explode(".",$archivo["name"]);
			$extension=array_pop($aux);
			$nombre_archivo=implode($aux);
			$nombre_archivo.= "_".rand(0,99999).".".$extension;

			$ruta="../downloads/tareas/".$nombre_archivo;

			if(!move_uploaded_file($archivo["tmp_name"],$ruta)){
				echo "Error subiendo el archivo";
			}
			else{
				mysql_query("INSERT INTO archivos_tarea (archivo, id_usuario_owner, id_tarea) VALUES('".$nombre_archivo."','".$_SESSION["id_usr"]."','".$id_nuevo."')",$link);
				echo mysql_error($link);
			}
		}
	}

	for($i=0;$i<3;$i++){
		actualizar_tareas($_GET["id_proyecto"]);
	}

	if($_POST["notificar"] == 1){
		if($_SESSION["id_usr"] == $_POST["id_usuario_responsable"]){
			if(!isset($_GET["id_tarea"])){
				$fila_tmp_not = mysql_fetch_assoc(mysql_query("SELECT id_usuario_supervisor FROM proyectos WHERE id_proyecto = ".$_GET["id_proyecto"],$link));
				echo mysql_error($link);
				$usuario_notificar = $fila_tmp_not["id_usuario_supervisor"];
			}
			else{
				$fila_tmp_not = mysql_fetch_assoc(mysql_query("SELECT id_usuario_owner FROM tareas WHERE id_tarea = ".$_GET["id_tarea"],$link));
				echo mysql_error($link);
				$usuario_notificar = $fila_tmp_not["id_usuario_owner"];
			}
		}
		else{
			$usuario_notificar = $_POST["id_usuario_responsable"];
		}

		$consulta_notificacion = "INSERT INTO usuarios_notificaciones (id_usuario, id_tarea, id_usuario_owner) VALUES('".$usuario_notificar."','".$id_nuevo."','".$_SESSION["id_usr"]."')";
		mysql_query($consulta_notificacion,$link);
		echo mysql_error($link);
		
		if(!isUserOnline($usuario_notificar)){
			enviarMailNotificacion($id_nuevo, $usuario_notificar);
		}
	}

	//actualizar estado del proyecto
	$result_consulta = mysql_query("SELECT COUNT(*) AS nro FROM tareas WHERE id_proyecto = ".$_GET["id_proyecto"]."",$link);
	echo mysql_error($link);
	$fila_tmp=mysql_fetch_array($result_consulta);
	$nro_total=$fila_tmp["nro"];
	$result_consulta = mysql_query("SELECT COUNT(*) AS nro FROM tareas WHERE id_proyecto = ".$_GET["id_proyecto"]." AND id_estado_tarea = 1",$link);
	echo mysql_error($link);
	$fila_tmp=mysql_fetch_array($result_consulta);
	$nro_pendientes=$fila_tmp["nro"];
	$result_consulta = mysql_query("SELECT COUNT(*) AS nro FROM tareas WHERE id_proyecto = ".$_GET["id_proyecto"]." AND id_estado_tarea = 3",$link);
	echo mysql_error($link);
	$fila_tmp=mysql_fetch_array($result_consulta);
	$nro_finalizadas=$fila_tmp["nro"];

	if($nro_total==$nro_pendientes){
		mysql_query("UPDATE proyectos SET id_estado_proyecto = 1 WHERE id_proyecto = ".$_GET["id_proyecto"]."",$link);
		echo mysql_error($link);
		mysql_query("UPDATE proyectos SET fecha_inicio_real='0000-00-00', fecha_fin_real='0000-00-00' WHERE id_proyecto = ".$_GET["id_proyecto"]."",$link);
		echo mysql_error($link);
	}
	else{
		if($nro_total==$nro_finalizadas){
			$result_consulta = mysql_query("SELECT * FROM proyectos WHERE id_proyecto = ".$_GET["id_proyecto"]."",$link);
			$fila_tmp=mysql_fetch_array($result_consulta);
			$stringq="UPDATE proyectos SET id_estado_proyecto = 3 ";

			if($fila_tmp["fecha_inicio_real"]=="0000-00-00"){
				$stringq.=", fecha_inicio_real=NOW() ";
			}

			if($fila_tmp["fecha_fin_real"]=="0000-00-00"){
				$stringq.=", fecha_fin_real=NOW() ";
			}

			$stringq.="WHERE id_proyecto='".$_GET["id_proyecto"]."'";
			mysql_query($stringq,$link);
			echo mysql_error($link);
		}
		else{
			$result_consulta = mysql_query("SELECT * FROM proyectos WHERE id_proyecto = ".$_GET["id_proyecto"]."",$link);
			$fila_tmp=mysql_fetch_array($result_consulta);
			$stringq="UPDATE proyectos SET id_estado_proyecto = 2 ";

			if($fila_tmp["fecha_inicio_real"]=="0000-00-00"){
				$stringq.=", fecha_inicio_real=NOW() ";
			}

			$stringq.=", fecha_fin_real='0000-00-00' ";
			$stringq.="WHERE id_proyecto='".$_GET["id_proyecto"]."'";
			mysql_query($stringq,$link);
			echo mysql_error($link);
		}
	}
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
	padding: 10px;
}
-->
</style>
<link href="clases/ABMControls/datePicker/styles/fsdateselect.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de administraci&oacute;n</title>
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_library/funciones.js"></script>
</head>
<body>
<div id="contenedor_loading_pop">
  <div id="loading_pop">Espere porfavor...<br />
    <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script language="JavaScript">
<!--
	setTimeout('parent.recargar()', 1000);
	setTimeout('parent.hidePopWin()', 1000);
//-->
</script>
</body>
</html>
