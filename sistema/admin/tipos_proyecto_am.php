<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"tipos_proyecto","tipos_proyecto","id_tipo_proyecto","Proyectos","Tipos de proyectos",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",40,0,true,"Descripci&oacute;n es requerida.");

$abm->show();
?>