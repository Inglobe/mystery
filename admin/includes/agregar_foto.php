<?php
	${$nom_archivo."_ok"}=false;
	${"nombre_".$nom_archivo} = "";
	if($_FILES["foto_".$nom_archivo]["name"]!=NULL){
		${"nombre_".$nom_archivo} = rand(1,99999)."_".$_FILES["foto_".$nom_archivo]["name"];
		if(!move_uploaded_file($_FILES["foto_".$nom_archivo]["tmp_name"], $path.${"nombre_".$nom_archivo})){
			echo "<br><b>ERROR ".${"nombre_".$nom_archivo}."</b><br>";
		}
		else{
			${$nom_archivo."_ok"}=true;
		}
	}
	$ruta = $path.${"nombre_".$nom_archivo};
	if($_POST["borrar_foto_".$campos["nombre_campo"]] != 1 && $_FILES["foto_".$campos["nombre_campo"]]["name"] != ""){
		require("procesar_imagen.php");
	}
?>