<?php
	${$nom_archivo."_ok"}=false;
	if(${"data_".$nom_archivo} != "none" AND ${"data_".$nom_archivo."_size"} != 0){
		${"nombre_".$nom_archivo} = rand(1,99999)."_".${"data_".$nom_archivo."_name"};
		if (!copy (${"data_".$nom_archivo},  $path.${"nombre_".$nom_archivo})){
			echo "<br><b>NO SE PUDO SUBIR EL ARCHIVO ".${"nombre_".$nom_archivo}."</b><br>";
		}
		else{
			${$nom_archivo."_ok"}=true;
		}
	}
?>