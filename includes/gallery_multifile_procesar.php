<?php
require("../includes/conexion.inc.php");

if ($_REQUEST['uploadDir']) {
	$aux = explode("|",$_REQUEST['uploadDir']);
	$id_relacion = $aux[0];
	$nombre_abm = $aux[1];

	$nom_archivo = rand(1,99999)."_".$_FILES['Filedata']['name'];
	$ruta = "../imagenes/galeria/fotos/".$nom_archivo;
	
	move_uploaded_file($_FILES['Filedata']['tmp_name'], $ruta);
	require("../admin/includes/procesar_imagen.php");

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT (MAX(orden) + 1) AS nro FROM fotos where id_relacion = ".$id_relacion." AND abm = '".$nombre_abm."'",$link));
	echo mysql_error($link);

	$consulta = "INSERT INTO 	fotos
								( foto
								, id_relacion
								, orden
								, abm)
						 VALUES ( '".$nom_archivo."'
						 		, '".$id_relacion."'
								, '".$fila_tmp["nro"]."'
								, '".$nombre_abm."')
			";
	mysql_query($consulta,$link);
	echo mysql_error($link);
}
if ($_REQUEST['action'] == 'getMaxFilesize') {
	echo "&maxFilesize=".ini_get('upload_max_filesize');
}
?>