<?php
	if(isset($id_db)){
		$id_auto=$id_db;
	}
	else{
		$id_auto=$id_combo;
	}
	if(isset($link_sitio)){
		$conexion_db=${$link_db};
	}
	else{
		$conexion_db=$link;
	}
	echo "<select ";
	if(isset($nombre_estilo)){
		echo "class=\"".$nombre_estilo."\" ";
	}
	echo "name=\"$id_combo\" ";
	if($desactivar){
		echo "disabled ";
	}
	if(isset($on_change))
		echo " onchange=\"$on_change\" ";
	if(isset($id_javascript))
		echo " id=\"$id_javascript\" ";
	echo ">\n";
	if(isset($item_ninguno)){
		echo "<option value=\"0\">$item_ninguno</option>\n";
	}
	$result_combo = mysql_query($cadena_combo,$conexion_db);
	while($fila_combo=mysql_fetch_array($result_combo)){
		echo "<option value=\"".$fila_combo[$id_auto]."\" ";
		if(isset(${$id_combo})){
			if(${$id_combo}==$fila_combo[$id_auto])
				echo "selected";
			if($accion!="m" && $id_defecto == $fila_combo[$id_auto])
				echo "selected";
		}
		echo ">".$fila_combo[$campo_mostrar]."</option>\n";
	}
	echo "</select>\n";
	echo mysql_error($conexion_db);
	unset($id_combo,$id_auto,$id_db,$desactivar,$item_ninguno,$campo_mostrar,$cadena_combo,$nombre_estilo,$conexion_db,$link_sitio,$on_change);
?>