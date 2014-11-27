<?php
require_once('../includes/config.php');
require_once('../includes/paths.php');

require_once(PATH_ADMIN_PROCESOS_GLOBALES);

$id = $data->get("id",DATA_EX_TYPE_INT);

$db = new database;
$sql = "SELECT * FROM newsletters WHERE id_newsletter = ".$db->escape($id);
$db->query($sql);
if($db->fetch()){
	echo $db->getValue("content");
}
?>