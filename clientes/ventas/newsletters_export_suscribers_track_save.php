<?php
	require_once('../includes/config.php');
	require_once('../includes/paths.php');

	require_once(PATH_ADMIN_PROCESOS_GLOBALES);

	$id = $data->get("id",DATA_EX_TYPE_INT);
	
	require_once("../includes/zip.lib.php");

	$delimitador_car=";";
	
	$nom_archivo_zip = "Contactos aperturas - Newsletter ".$id;
	$zipfile = new zipfile();
	
	//obtener aperturas
	$nom_archivo_csv = "Aperturas";

	$db = new database;
	$db_consulta ="SELECT 
						s.*
					FROM 
						mailbox m
						LEFT JOIN suscribers s ON m.id_suscriber = s.id_suscriber 
					WHERE 
						m.id_newsletter = ".$id."
				";
	//echo $db_consulta."<hr />";

	$db->query($db_consulta);

	$cont_total = 0;
	$cont_aperturas = 0;
	$cont_no_aperturas = 0;
	
	$titulos = '"E-mail"'.$delimitador_car.'"Nombre"'.$delimitador_car.'"Fecha"'."\r\n";
	
	while($db->fetch()){
		$fila = $db->getValues();
		if(empty($fila["id_suscriber"])){
			$fila["id_suscriber"] = 0;
		}
		
		$cont_total++;
		
		$db_ap = new database;
		$query_aperturas = "SELECT *, DATE_FORMAT(track_date, '%d-%m-%Y %H:%i') AS track_date_f FROM tracking WHERE id_suscriber = ".$fila["id_suscriber"]." LIMIT 1";
		//echo "<hr />".$query_aperturas;
		$db_ap->query($query_aperturas);
		$db_ap->fetch();
		$fila_aperturas = $db_ap->getValues();
		
		$linea_csv = '"'.$fila["email"].'"'.$delimitador_car.'"'.$fila["name"].'"'.$delimitador_car.'"'.$fila_aperturas["track_date_f"].'"'."\r\n";
		
		$num_rows_ap = $db_ap->getRows();
		if($num_rows_ap==1){
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