<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"encuestas","encuestas","id_encuesta","Sistema","Encuestas",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&oacute;n","descripcion_es","","\\\\.","",60,0,true,"Descripcion es requerido.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>