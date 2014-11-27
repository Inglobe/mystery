<?
require("procesos_globales.php");

$fila = mysql_fetch_assoc(mysql_query("SELECT monto FROM hosting_planes WHERE id_plan = ".$_GET["id"],$link));
echo $fila["monto"];
?>