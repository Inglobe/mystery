<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"registrars","registrars","id_registrar","Hosting","Registrars",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&otilde;n","descripcion","","\\\\.","",40,0,true,"Descripci&oacute;n es requerido.");
$abm->addTextField("Monto","monto","","\\\\.","",10,10,false,"");
$abm->addCheckBox("Renovaci&oacute;n","renovacion",1);
$abm->addTextField("Meses renovaci&oacute;n","meses_renovacion","","\\\\.","",2,0,false,"");

$abm->show();
?>