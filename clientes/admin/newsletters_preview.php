<?php
require_once('../includes/config.php');
require_once('../includes/paths.php');

require_once(PATH_ADMIN_PROCESOS_GLOBALES);

$template = "default_template";

$subject = $data->post("subject");
$descripcion = $data->post("descripcion");

ob_start();
require("../newsletters/".$template."/newsletter.php");
$buffer_html = ob_get_contents();
ob_end_clean();
$buffer_html = str_replace("\\","",$buffer_html);
echo $buffer_html;
?>