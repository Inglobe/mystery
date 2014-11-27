<?php
		if (${"foto_".$nom_archivo} != NULL || ${"borrar_".$nom_archivo} == 1 || $abm_accion == "d"){
			$result=mysql_query("SELECT ".$nom_campo." FROM ".$tabla_nombre." WHERE ".$id_nombre." = ".$id,$link);
			echo mysql_error($link);
			$fila_arch=mysql_fetch_array($result);
			if($fila_arch[$nom_campo] != ""){
				unlink($path.$fila_arch[$nom_campo]);
			}
		}
?>