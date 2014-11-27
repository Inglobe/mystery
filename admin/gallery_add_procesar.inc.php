<?php

if($_POST["abm_accion"] == "a"){
	//ECHO "ASDASDSADA";
	$orden = 0;
	foreach($_FILES as $clave => $archivo){
		if(strpos($clave, "multifile") == 0 && $archivo["name"] != ""){
			//echo " - ENTRO - ";
			$orden++;

			$nombre_archivo = rand(1,99999)."_".$archivo["name"];

			$ruta="../imagenes/galeria/fotos/".$nombre_archivo;

			//echo $ruta;
			move_uploaded_file($archivo["tmp_name"],$ruta);
			require("includes/procesar_imagen.php");

			$cadena = "INSERT INTO 	fotos
									( foto
									, id_relacion
									, orden
									, abm)
							 VALUES ( '".$nombre_archivo."'
							 		, '".$id_nuevo."'
									, '".$orden."'
									, '".$tabla_nombre."')
					";
			if(mysql_query($cadena,$link)){
				//echo " - insertada -";
			}
			echo mysql_error($link);
		}
	}
}
?>