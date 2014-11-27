<?
	require_once("../includes/conexion.inc.php");
	
	$id_grupo = 5;
	
	$result_usuarios = mysql_query("SELECT * FROM usuarios",$link);
	while($fila = mysql_fetch_assoc($result_usuarios)){
		$result_tmp = mysql_query("SELECT id_usuario_news FROM usuarios_news WHERE email LIKE '".$fila["email"]."'");
		echo mysql_error($link);
		if(mysql_num_rows($result_tmp)==0){
			$consulta = "INSERT INTO usuarios_news 
									(nombre
									,email
									,id_grupo_news
									,activo)
								VALUES
									('".$fila["nombre"]." ".$fila["apellido"]."'
									,'".$fila["email"]."'
									,".$id_grupo."
									,1)
						";
			//echo "<li>".$fila["nombre"]." ".$fila["apellido"].": <font color=green>Nuevo</font> </li>";
		}
		else{
			$fila_tmp =  mysql_fetch_assoc($result_tmp);
			$consulta = "UPDATE usuarios_news SET
									nombre = '".$fila["nombre"]." ".$fila["apellido"]."'
									,email = '".$fila["email"]."' 
									,id_grupo_news = '".$id_grupo."'
								WHERE
									id_usuario_news = ".$fila_tmp["id_usuario_news"]."
						";
			//echo "<li>".$fila["nombre"]." ".$fila["apellido"].": Actualizado </li>";
		}

		mysql_query($consulta,$link);
		echo mysql_error($link);
	}
?>
