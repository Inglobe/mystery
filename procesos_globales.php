<?php
session_start();
include("includes/funciones_generales.php");
session_name("sitio");
session_register("put");
session_register("id_pais_sitio");

include("includes/conexion.inc.php");
include("funciones.php");

//INCLUSION
if(isset($_GET["put"]))
	$_SESSION["put"]=$_GET["put"];
if(isset($_POST["put"]))
	$_SESSION["put"]=$_POST["put"];
if($_SESSION["put"] == NULL || count($_GET) == 0)
	$_SESSION["put"] = "home";

//CRITERIO BUSQUEDA
session_register("criterio_busqueda");
if(isset($_GET["criterio_busqueda"]))
	$_SESSION["criterio_busqueda"]=$_GET["criterio_busqueda"];

if(substr_count($_SESSION["put"],"http://") < 1){
	if (($fp = @fopen($_SESSION["put"].".php", 'r', 1)) and fclose($fp)){
	}
	else{
		$_SESSION["put"] = "home";
	}
}

$put=$_SESSION["put"];

$result_consulta = mysql_query("SELECT * FROM parametros",$link);
$fila_parametros=mysql_fetch_array($result_consulta);

setlocale(LC_ALL,"spanish");
?>