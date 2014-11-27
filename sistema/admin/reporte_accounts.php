<?php
require("procesos_globales.php");
require("clases/Report/Report.class.php");

$reporte = new Report("Reporte de cuentas en el hosting",1);

//$reporte->showDate = false;
//$reporte->showPagesNums = false;
$reporte->showPrintDialog = true;
$reporte->orientation = 1;
$reporte->showUsers = true;
//$reporte->useJavascript = true;

$reporte->dataHeaders = array("Dominio","Usuario","Password","Fecha alta","Reseller");
$consulta = "SELECT
				domain
				, username
				, AES_DECRYPT(password,CONCAT(username,'_FRZ')) AS pass
				, DATE_FORMAT(created,'%d/%m/%Y') AS created_f
				, reseller
			FROM
				accounts";

$result = mysql_query($consulta,$link_ferozo);

$total_tiempo=0;
echo mysql_error($link);
while($fila = mysql_fetch_assoc($result)){
	$cuentas[] = $fila;
}

$reporte->data = $cuentas;

//$reporte->addTextLine("Filtro 1","Texto del filtro 1");
//$reporte->addTextLine("Fecha desde","12/12/2009");
//$reporte->addTextLine("Filtro 2","Texto del filtro 2");

$reporte->addFooterTotal("Total de cuentas",mysql_num_rows($result));

$reporte->show();

//$reporte->downloadCSV();
?>