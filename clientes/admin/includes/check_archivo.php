<?php
		if (${"data_".$nom_archivo} != NULL || ${"borrar_".$nom_archivo} == 1){
			$result=mysql_query("SELECT * FROM ".$tabla_nombre." WHERE ".$id_nombre." = ".$id,$link);
			$fila_arch=mysql_fetch_array($result);
			if($fila_arch[$nom_campo]!="")
				unlink($path.$fila_arch[$nom_campo]);
		}
?>