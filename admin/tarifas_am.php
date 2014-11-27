<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"tarifas","tarifas","id_tarifa","Sitio","Tarifas",$_GET["abm_accion"],$_GET["id"],false);

$abm->addCombo("Tipo","id_tipo_tarifa",$link,"SELECT * FROM tipos_tarifas ORDER BY descripcion ASC","id_tipo_tarifa","descripcion",0,"--seleccionar--",true,"Seleccione tipo.");
$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",70,0,false," es requerido.");
$abm->addTextField("Monto","monto","","\\\\.","",70,0,false," es requerido.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>