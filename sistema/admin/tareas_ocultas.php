<?
	require_once("procesos_globales.php");
	if(isset($_GET["accion"]) && isset($_GET["id_tarea"])){
		switch($_GET["accion"]){
			case "a":
				$consulta = "INSERT INTO tareas_ocultas (id_tarea,id_usuario) VALUES ('".$_GET["id_tarea"]."', '".$_SESSION["id_usr"]."')";
			break;
			case "o":
				$consulta = "DELETE FROM tareas_ocultas WHERE id_tarea = ".$_GET["id_tarea"]." AND id_usuario = ".$_SESSION["id_usr"];
			break;
		}
		mysql_query($consulta, $link);
	}
?>