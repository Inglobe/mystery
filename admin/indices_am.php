<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"indices","indices","id_indice","Sitio","Indices",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("T&iacute;tulo","titulo","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Descripci&oacute;n","descripcion","","\\\\.","",80,4,false,"requerida.");
$abm->addTextField("URL","url","","\\\\.","",70,0,false,"Titulo es requerido.");
$abm->addTextField("Palabras Clave","palabras_clave","","\\\\.","",70,0,false,"Palabras clave es requerido.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>