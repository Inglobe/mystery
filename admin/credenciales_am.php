<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"credenciales","credenciales","id_credencial","Sistema","Credenciales",$_GET["abm_accion"],$_GET["id"],false);

//Combo Secciones
$abm->addDate("Valida desde","valida_desde",date("Y-m-d",time()));
$abm->addDate("Valida hasta","valida_hasta",date("Y-m-d",time()));
$abm->addCombo("Usuario","id_usuario",$link,"SELECT *, CONCAT(nombre,' ',apellido) AS nombre_usuario FROM usuarios ORDER BY nombre, apellido ASC","id_usuario","nombre_usuario",0,"--seleccionar--",true,"Seleccione grupo.");

$abm->show();
?>