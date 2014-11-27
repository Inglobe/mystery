<?
session_name("admin");
session_start();
//session_register("put");

//INCLUSION
if(isset($_GET["put"])){
	$put=$_GET["put"];
}
else{
	$put = "home";
}

$idioma="es";

require_once("../includes/conexion.inc.php");
require_once("../includes/funciones_generales.php");
require_once("idioma/".$idioma."/idioma.php");
require_once("funciones.php");

$result_consulta = mysql_query("SELECT * FROM parametros",$link);
$fila_parametros = mysql_fetch_array($result_consulta);
$paginacion = $fila_parametros["paginacion"];

$abm_skin="gris";
?>