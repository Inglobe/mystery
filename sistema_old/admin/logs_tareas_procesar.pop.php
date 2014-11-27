<?
	require_once("../includes/conexion.inc.php");

	if($_POST["accion"] == "a"){
		$_GET["accion"] = "a";
	}

	switch($_GET["accion"]){
		case "d":
			$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT id_tarea FROM logs_tareas WHERE id_log_tarea = ".$_GET["id_eliminar"],$link));
			mysql_query("DELETE FROM logs_tareas WHERE id_log_tarea = ".$_GET["id_eliminar"],$link);
			$_POST["id_tarea"] = $fila_tmp["id_tarea"];
		break;
		case "a":
			$stringq="
				INSERT INTO logs_tareas (
					fecha,
					descripcion,
					id_tarea,
					id_usuario
				) VALUES (
					NOW(),
					'".utf8_decode($_POST["descripcion"])."',
					'".$_POST["id_tarea"]."',
					'".$_POST["id_usr"]."'
				)
			";
			mysql_query($stringq,$link);
			echo mysql_error($link);
		break;
	}
?>
<input type="hidden" name="id_tarea" id="id_tarea" value="<?=$_POST["id_tarea"]?>" />
<div id="contenedor_loading_pop">
  <div id="loading_pop">Espere porfavor...<br />
    <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>