<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"calendario","calendario","id_calendario","Sitio","Calendario",$_GET["abm_accion"],$_GET["id"],false);

$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("T&iacute;tulo","titulo","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Descripci&oacute;n","descripcion","","\\\\.","",80,4,false,"requerida.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>