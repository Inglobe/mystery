<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"testimonios","testimonios","id_testimonio","Sitio","Testimonios",$_GET["abm_accion"],$_GET["id"],false);

$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("Nombre y apellido","nombre_apellido","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Testimonio","testimonio","","\\\\.","",80,4,false,"requerida.");
$abm->addCheckBox("Autorizado","autorizado",1);

$abm->show();
?>