<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"planes","hosting_planes","id_plan","Hosting","Planes",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&otilde;n","descripcion","","\\\\.","",40,0,true,"Descripci&oacute;n es requerido.");
$abm->addTextField("Monto","monto","","\\\\.","",10,10,false,"");
$abm->addTextField("Meses renovaci&oacute;n","meses_renovacion","","\\\\.","",2,0,false,"");
$abm->addRichText("Detalle","detalle","",400);

$abm->show();
?>