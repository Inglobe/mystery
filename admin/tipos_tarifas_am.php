<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"tipos_tarifas","tipos_tarifas","id_tipo_tarifa","Sitio","Tipos de tarifa",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",80,0,true,"Descripción requerida.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>