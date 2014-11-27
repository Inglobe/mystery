<?php
require_once('../../../includes/config.php');
require_once('../../../includes/paths.php');

require_once(PATH_ADMIN_PROCESOS_GLOBALES);

$indice = 0;

$db = new database;

foreach($_POST['fotos'] as $id_foto){
	$db->query("UPDATE fotos SET orden = ".$indice." WHERE id_foto = ".(int)$id_foto);
		
	$indice++;
}
?>
