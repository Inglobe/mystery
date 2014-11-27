<?php
require("procesos_globales.php");
require("clases/Report/Report.class.php");

if(isset($_GET["id_usuario"])){
	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT nombre FROM usuarios WHERE id_usuario = ".$_GET["id_usuario"],$link));
}

$reporte = new Report("Reporte de Horas Reales ".(isset($_GET["id_usuario"])?" de ".$fila_tmp["nombre"]:""),1);

//$reporte->showDate = false;
//$reporte->showPagesNums = false;
$reporte->showPrintDialog = true;
$reporte->orientation = 1;
$reporte->showUsers = true;
//$reporte->useJavascript = true;

$consulta_usuarios="SELECT
						u.id_usuario,
						u.nombre,
						u.user,
						u.foto
					FROM
						tareas t,
						usuarios u
					WHERE
						(t.id_usuario_responsable = u.id_usuario OR t.id_usuario_owner = u.id_usuario) AND
						t.id_proyecto = ".$_GET["id_proyecto"]."
					";
if(isset($_GET["id_usuario"])){
	$consulta_usuarios.=" AND u.id_usuario = ".$_GET["id_usuario"];
}

$result_usuarios = mysql_query($consulta_usuarios,$link);
echo mysql_error($link);
while($fila_usuario = mysql_fetch_assoc($result_usuarios)){
	$usuarios[$fila_usuario["id_usuario"]] = $fila_usuario;
}

$reporte->dataUsers = $usuarios;

$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT * FROM proyectos WHERE id_proyecto = ".$_GET["id_proyecto"],$link));
$reporte->addTextLine("Proyecto", $fila_tmp["nombre"]);

$reporte->dataHeaders = array("Tarea","Responsable","Inicio","Fin","Tiempo","Estado","Minutos","Ruta");
$consulta = "SELECT
				t.descripcion,
				u.nombre AS usuario,
				DATE_FORMAT(t.fecha_alta,'%d/%m/%Y') AS fecha_inicio,
				DATE_FORMAT(t.fecha_modificacion,'%d/%m/%Y') AS fecha_fin,
				CONCAT(t.tiempo,' mins.') AS tiempo_f,
				t.id_estado_tarea,
				et.descripcion AS estado,
				t.id_tarea,
				t.tiempo
			FROM
				tareas t,
				estados_tarea et,
				usuarios u
			WHERE
				t.id_usuario_responsable = u.id_usuario AND
				et.id_estado_tarea = t.id_estado_tarea AND
				t.id_proyecto = ".$_GET["id_proyecto"]."
		";
if(isset($_GET["id_usuario"])){
	$consulta.=" AND u.id_usuario = ".$_GET["id_usuario"];
}
$result = mysql_query($consulta." ORDER BY t.fecha_alta ASC, t.id_tarea ASC",$link);

$total_tiempo=0;
echo mysql_error($link);
while($fila = mysql_fetch_assoc($result)){
	if($fila["tiempo"]>0){
		$fila["estado"] = '<img src="imagenes/estado_'.$fila["id_estado_tarea"].'.gif" alt="" width="10" height="10" hspace="3" />'.$fila["estado"];
		
		$tmp = explode("/",getTareasPadres($fila["id_tarea"]));
		array_shift($tmp);
		$fila["ruta"] = implode("/",$tmp);
		
		unset($fila["id_tarea"]);
		unset($fila["id_estado_tarea"]);
		$tareas[] = $fila;
		$total_tiempo+= $fila["tiempo"];
	}
}

$reporte->data = $tareas;

//$reporte->addTextLine("Filtro 1","Texto del filtro 1");
//$reporte->addTextLine("Fecha desde","12/12/2009");
//$reporte->addTextLine("Filtro 2","Texto del filtro 2");

$reporte->addFooterTotal("Total horas",number_format(ceil($total_tiempo/60),0))." Hs.";

if($_GET["descargar"]==1){
	$reporte->downloadCSV();
}
else{
	$reporte->show();
}
?>