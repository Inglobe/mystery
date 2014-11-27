<?
require("../includes/conexion.inc.php");

$id_usuario_news=$_GET["id_usuario_news"];
$id_newsletter=$_GET["id_newsletter"];
if($id_usuario_news!="[id_usuario_news]"){
	$fila_check=mysql_fetch_array(mysql_query("SELECT COUNT(*) AS NRO FROM trackeo WHERE id_usuario_news = '".$id_usuario_news."' AND id_newsletter = '".$id_newsletter."'",$link));
	echo mysql_error($link);

	if($fila_check["NRO"]==0){
		mysql_query("INSERT INTO trackeo VALUES('".$id_usuario_news."','".$id_newsletter."',NOW(),'".$_SERVER["REMOTE_ADDR"]."')");
	}
}
header("Content-type: image/jpeg");
imagejpeg(imagecreatetruecolor(1,1));
?>