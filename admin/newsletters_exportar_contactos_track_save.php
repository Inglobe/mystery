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
		default;
			$delimitador_car=";";
	}
	
	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT DATE_FORMAT(fecha,'%d-%m-%Y') AS fecha_f FROM newsletters WHERE id_newsletter = ".$_GET["id"]." LIMIT 1",$link));
	
	$nom_archivo_zip = "Contactos aperturas - Newsletter ".$_GET["id"]." - ".$fila_tmp["fecha_f"];
	$zipfile = new zipfile();
	
	//obtener aperturas
	$nom_archivo_csv = "Aperturas";

	$db_consulta ="SELECT 
						un.*
					FROM 
						mailbox m
						LEFT JOIN usuarios_news un ON m.id_usuario_news = un.id_usuario_news 
					WHERE 
						m.id_newsletter = ".$_GET["id"]."
				";
	//echo $db_consulta."<hr />";

	$result_consulta = mysql_query($db_consulta, $link);
	echo mysql_error($link);
	$cont_total = 0;
	$cont_aperturas = 0;
	$cont_no_aperturas = 0;
	
	$titulos = '"E-mail"'.$delimitador_car.'"Nombre"'.$delimitador_car.'"Fecha"'."\r\n";
	
	while($fila = mysql_fetch_array($result_consulta)){
		if(empty($fila["id_usuario_news"])){
			$fila["id_usuario_news"] = 0;
		}
		
		$cont_total++;
		
		$query_aperturas = "SELECT *, DATE_FORMAT(fecha,'%d-%m-%Y %H:%i') AS fecha_f FROM trackeo WHERE id_usuario_news = ".$fila["id_usuario_news"]." LIMIT 1";
		//echo "<hr />".$query_aperturas;
		$result_aperturas = mysql_query($query_aperturas,$link);
		echo mysql_error($link);
		$fila_aperturas = mysql_fetch_assoc($result_aperturas);
		
		$linea_csv = '"'.$fila["email"].'"'.$delimitador_car.'"'.$fila["nombre"].'"'.$delimitador_car.'"'.$fila_aperturas["fecha_f"].'"'."\r\n";
		
		if(mysql_num_rows($result_aperturas)==1){
			$contenido_csv_aperturas.= $linea_csv;
			$cont_aperturas++;
		}
		else{
			$contenido_csv_no_aperturas.= $linea_csv;
			$cont_no_aperturas++;
		}
	}
	
	$contenido_csv_aperturas.= "Total: ".$cont_aperturas;
	$contenido_csv_no_aperturas.= "Total: ".$cont_no_aperturas;
	
	//echo "<hr />".$contenido_csv_aperturas;
	//echo "<hr />".$contenido_csv_no_aperturas;
	
	$zipfile->addFile($titulos.$contenido_csv_aperturas, "aperturas.csv");
	$zipfile->addFile($titulos.$contenido_csv_no_aperturas, "no_aperturas.csv");
	
	$salida = $zipfile->file();

	header('Content-Type: application/octet-stream');
	header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
	header('Content-Disposition: inline; filename="' . $nom_archivo_zip . '.zip"');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');

	print $salida;
?>