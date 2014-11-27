<?php
require("procesos_globales.php");
require("clases/Report/Report.class.php");

$reporte = new Report("Proyectos pendientes",1);

//$reporte->showDate = false;
//$reporte->showPagesNums = false;
//$reporte->showPrintDialog = true;
//$reporte->orientation = 1;
//$reporte->useJavascript = true;

$reporte->dataHeaders = array("ID","Nombre","Cliente","Supervisor","Inicio","Fin","Entrega","Estado","Avance");

$consulta = "
			SELECT
				p.id_proyecto,
				p.nombre,
				cl.nombre AS cliente,
				us.nombre AS supervisor,
				DATE_FORMAT(p.fecha_inicio_estimada,'%d/%m/%Y') AS fecha_inicio_f,
				DATE_FORMAT(p.fecha_fin_estimada,'%d/%m/%Y') AS fecha_fin_f,
				DATE_FORMAT(p.fecha_entrega_estimada,'%d/%m/%Y') AS fecha_entrega_f,
				ep.descripcion AS estado,
				p.id_estado_proyecto
			FROM
				proyectos p,
				estados_proyecto ep,
				clientes cl,
				usuarios us
			WHERE
				p.id_cliente = cl.id_cliente
				AND p.id_estado_proyecto = ep.id_estado_proyecto
				AND p.id_usuario_supervisor = us.id_usuario
				AND p.id_estado_proyecto < 3
			ORDER BY
				p.fecha_fin_estimada ASC
		";

$result = mysql_query($consulta,$link);
echo mysql_error($link);
while($fila = mysql_fetch_assoc($result)){
	$fila["avance"] = avance_ponderado($fila["id_proyecto"])."%";
	$fila["estado"] = '<img src="imagenes/estado_'.$fila["id_estado_proyecto"].'.gif" alt="" width="10" height="10" hspace="3" />'.$fila["estado"];
	unset($fila["id_estado_proyecto"]);
	$proyectos[] = $fila;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT monto_debe, monto_haber FROM proyectos WHERE id_proyecto = ".$fila["id_proyecto"],$link));
	$monto_total_pendiente+= $fila_tmp["monto_debe"];
	$monto_total+= $fila_tmp["monto_debe"] + $fila_tmp["monto_haber"];
}

$reporte->data = $proyectos;

//$reporte->addTextLine("Filtro 1","Texto del filtro 1");
//$reporte->addTextLine("Fecha desde","12/12/2009");
//$reporte->addTextLine("Filtro 2","Texto del filtro 2");

$reporte->addFooterTotal("Total de proyectos",mysql_num_rows($result));
$reporte->addFooterTotal("Monto pendiente total",number_format(round($monto_total_pendiente,2),2));
$reporte->addFooterTotal("Monto total",number_format(round($monto_total,2),2));

$reporte->show();

//$reporte->downloadCSV();
?>