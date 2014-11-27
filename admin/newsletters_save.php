<?php
require("../includes/conexion.inc.php");
$result = mysql_query("SELECT * FROM newsletters WHERE id_newsletter = ".$_GET["id"],$link);
if($fila = mysql_fetch_array($result)){
	$nom_archivo = "Newsletter_".$_GET["id"];
	header('Content-Disposition: attachment; filename="' . $nom_archivo.".htm" . '"');
	header('Content-Type: application/octet-stream');
	header('Content-Length: '.strlen($fila["texto"]));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	print $fila["texto"];
}

?>