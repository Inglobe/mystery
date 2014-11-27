<?php
require_once('../includes/config.php');
require_once('../includes/paths.php');

require_once(PATH_ADMIN_PROCESOS_GLOBALES);

$id = $data->get("id",DATA_EX_TYPE_INT);

$db = new database;
$sql = "SELECT * FROM newsletters WHERE id_newsletter = ".$db->escape($id);
$db->query($sql);
if($db->fetch()){
	$nom_archivo = "Newsletter_".$id;
	
	$content = $db->getValue("content");
	
	header('Content-Disposition: attachment; filename="'.$nom_archivo.'.html'.'"');
	header('Content-Type: application/octet-stream');
	header('Content-Length: '.strlen($content));
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Pragma: public');
	print $content;
}

?>
