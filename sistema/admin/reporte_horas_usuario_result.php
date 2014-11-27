<?php
require("procesos_globales.php");
require("clases/Report/Report.class.php");

$reporte = new Report("Reporte de Horas Usuario",1);

//$reporte->showDate = false;
//$reporte->showPagesNums = false;
$reporte->showPrintDialog = true;
$reporte->orientation = 1;
//$reporte->useJavascript = true;

//print_r($_GET);
$reporte->dataHeaders = array("Tarea","Proyecto","Cliente","Carg&oacute;","Inicio","Fin","Tiempo","Estado");
$consulta = "
			SELECT
				t.descripcion,
				p.nombre AS proyecto,
				c.nombre AS cliente,
				u.nombre AS usuario,
				DATE_FORMAT(t.fecha_inicio_estimada,'%d/%m/%Y') AS fecha_inicio,
				DATE_FORMAT(t.fecha_fin_estimada,'%d/%m/%Y') AS fecha_fin,
				CONCAT(t.tiempo,'&nbsp;mins.') AS tiempo_f,
				t.id_estado_tarea,
				et.descripcion AS estado,
				t.id_tarea,
				t.tiempo
			FROM
				tareas t,
				proyectos p,
				clientes c,
				estados_tarea et,
				usuarios u
			WHERE
				t.id_usuario_owner = u.id_usuario AND
				t.id_proyecto = p.id_proyecto AND
				p.id_cliente = c.id_cliente AND
				et.id_estado_tarea = t.id_estado_tarea";

if(isset($_GET["filtro_fecha_from"]) && isset($_GET["filtro_fecha_to"])){
	$consulta .= " AND t.fecha_modificacion >= STR_TO_DATE('".$_GET["filtro_fecha_from"]."','%d/%m/%Y')";
	$reporte->addTextLine("Desde", $_GET["filtro_fecha_from"]);

	$consulta .= " AND t.fecha_modificacion <= STR_TO_DATE('".$_GET["filtro_fecha_to"]."','%d/%m/%Y')";
	$reporte->addTextLine("Hasta", $_GET["filtro_fecha_to"]);
}
if($_GET["filtro_id_usuario"] != 0){
	$consulta .= " AND t.id_usuario_responsable = ".$_GET["filtro_id_usuario"];
	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT * FROM usuarios WHERE id_usuario = ".$_GET["filtro_id_usuario"],$link));
	$reporte->addTextLine("Usuario", $fila_tmp["nombre"]);
}

//echo $consulta;

$consulta .= " ORDER BY t.fecha_inicio_estimada ASC";
$result = mysql_query($consulta,$link);

$total_tiempo=0;
echo mysql_error($link);
while($fila = mysql_fetch_assoc($result)){
	if($fila["tiempo"]>0){
		$fila["estado"] = '<img src="imagenes/estado_'.$fila["id_estado_tarea"].'.gif" alt="" width="10" height="10" hspace="3" />'.$fila["estado"];
		unset($fila["id__tarea"]);
		unset($fila["id_estado_tarea"]);
		$tareas[] = $fila;
		$total_tiempo+= $fila["tiempo"];
	}
}

$reporte->data = $tareas;

$reporte->addFooterTotal("Total horas",number_format(ceil($total_tiempo/60),0))." Hs.";

if(isset($_GET["download_x"])){
	$reporte->downloadCSV();
}else{
	$reporte->show();
}

?>