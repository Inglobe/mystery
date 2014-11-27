<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"galerias","galerias","id_galeria","Sitio","Galer&iacute;as",$_GET["abm_accion"],$_GET["id"],false);

$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("Nombre","nombre","","\\\\.","",70,0,true,"Nombre es requerido.");
$abm->addRichText("Descripci&oacute;n","descripcion","",400);
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>