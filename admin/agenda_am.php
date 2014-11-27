<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"agenda","agenda","id_agenda","Sitio","Calendario",$_GET["abm_accion"],$_GET["id"],false);
//Combo Secciones
$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("T&iacute;tulo","titulo","","\\\\.","",70,0,true,"Título es requerido.");
$abm->addTextArea("Descripci&oacute;n","descripcion","","\\\\.","",80,4,false,"Descripcion es requerida.");
$abm->addFoto("Foto","foto","","../imagenes/agenda/fotos/");
$abm->addCheckBox("Feriado Nacional","feriado_nacional",1);
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>