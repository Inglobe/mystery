<?
	require_once("../includes/conexion.inc.php");
	
	$result_usuarios = mysql_query("SELECT * FROM usuarios_news",$link);
	while($fila = mysql_fetch_assoc($result_usuarios)){
	
		$result_tmp = mysql_query("SELECT id_usuario FROM usuarios WHERE email LIKE '".$fila["email"]."'");
		echo mysql_error($link);
		if(mysql_num_rows($result_tmp)==0){
			echo $fila["nombre"]." (".$fila["id_usuario_news"].") No Existe <hr />";
			mysql_query("DELETE FROM usuarios WHERE id_usuario = ".$fila["id_usuario_news"],$link);
		}
	}
?>
