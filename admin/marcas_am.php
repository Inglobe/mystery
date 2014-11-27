<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"marcas","marcas","id_marca","Sitio","Marcas",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",80,0,true,"Descripción requerida.");
$abm->addFile("Logo","logo","","../imagenes/marcas/logos/");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>