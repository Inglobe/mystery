<?php
	
	ini_set('display_startup','off');

	require_once('../includes/config.php');
	require_once('../includes/paths.php');
	
	require_once(PATH_ADMIN_PROCESOS_GLOBALES);
	
	$preview = true;
	
	$db_tmp = new database;
	$sql = "SELECT 
				con.id_contacto 
			FROM 
				contactos con
				JOIN clientes c ON c.id_cliente = con.id_cliente
				JOIN proyectos p ON c.id_cliente = p.id_cliente
			WHERE 
				p.id_proyecto = ".$_GET["id"]."
			";
	
	$db_tmp->query($sql);
	$db_tmp->fetch();
	$_SESSION["id_usr"] = $db_tmp->getValue("id_contacto");
	
	require(PATH_ADMIN_MAIN);

?>