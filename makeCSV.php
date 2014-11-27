<?php
function makeCSV($datos,$nombre_archivo = ""){
	$separador = ";";
	$salto = "\r\n";

	if($nombre_archivo == ""){
		$nombre_archivo = "datos.csv";
	}

	$fp = fopen($nombre_archivo,"a+");
	$i = 0;
	$cadena="";
	foreach($datos as $campo){
		$cadena .= ($i==0?"":$separador).'"'.str_replace("\n","",$campo).'"';
		$i++;
	}
	fwrite($fp,$cadena.$salto);
	fclose($fp);
}
?>