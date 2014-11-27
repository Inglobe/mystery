<?php
	include('../includes/conexion.inc.php');
            
	parse_str($_POST['data']);
	for ($i = 0; $i < count($scroll); $i++) {
		$sql = mysql_query("UPDATE fotos SET orden = ".$i." WHERE id_foto = ".$scroll[$i], $link);
		echo mysql_error($link);
    }
	sleep(1);
?>
		