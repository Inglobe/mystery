<?php

	require_once("../includes/conexion.inc.php");
	require_once("../includes/zip.lib.php");

	switch($_POST["delimitador"]){
		case "PUNTOYCOMA";
			$delimitador_car=";";
		break;
		case "COMA";
			$delimitador_car=",";
		break;
		case "PUNTO";
			$delimitador_car=".";
		break;
		case "COMILLAS";
			$delimitador_car="\"";
		break;
		case "TAB";
			$delimitador_car="\t";
		break;
		case "ESPACIO";
			$delimitador_car=" ";
		break;
	}

	$nom_archivo_csv = "Todos";
	$nom_archivo_zip = "Libreta de direcciones - ".date("d-m-Y").".zip";

	$db_consulta ="SELECT * FROM usuarios_news";
	if($_POST["id_grupo_news"] != 0){
		$db_consulta.=" WHERE id_grupo_news = ".$_POST["id_grupo_news"];

		$fila_tmp = mysql_fetch_assoc(mysql_query("select descripcion from grupos_news where id_grupo_news = ".$_POST["id_grupo_news"],$link));
		echo mysql_error($link);
		$nom_archivo_csv = $fila_tmp["descripcion"];
	}

	$result_consulta = mysql_query($db_consulta, $link);
	echo mysql_error($link);

	while($fila = mysql_fetch_array($result_consulta)){
		$contenido_csv.=$fila["email"].$delimitador_car.$fila["nombre"].$delimitador_car.$fila["empresa"]."\r\n";
	}

	$zipfile = new zipfile();
	$zipfile -> addFile($contenido_csv, $nom_archivo_csv.".csv");
	$salida = $zipfile -> file();

	header('Content-Type: application/octet-stream');
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Content-Disposition: inline; filename="' . $nom_archivo_zip . '"');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	print $salida;
?>