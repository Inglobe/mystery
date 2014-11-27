<?php
	require("../includes/conexion.inc.php");
	$result = mysql_query("SELECT * FROM newsletters WHERE id_newsletter = ".$_GET["id"],$link);
	if($fila=mysql_fetch_array($result)){
		echo $fila["texto"];
	}
?>