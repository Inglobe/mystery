<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"links","links","id_link","Sitio","Links de inter&eacute;s",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("T&iacute;tulo","titulo","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Descripci&oacute;n","descripcion","","\\\\.","",80,4,false,"Descripcion es requerida.");
$abm->addTextField("Url","url","http://","\\\\.","",70,0,true,"Url es requerida.");

$abm->show();
?>