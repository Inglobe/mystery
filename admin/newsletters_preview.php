<?php
include("procesos_globales.php");

$template = $_POST["template"];
$asunto = $_POST["asunto"];
$descripcion = $_POST["descripcion"];

ob_start();
require("../newsletters/".$template."/newsletter.php");
$buffer_html = ob_get_contents();
ob_end_clean();
$buffer_html = str_replace("\\","",$buffer_html);
echo $buffer_html;


?>