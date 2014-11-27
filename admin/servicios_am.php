<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"servicios","servicios","id_servicio","Sitio","Servicios",$_GET["abm_accion"],$_GET["id"],false);

$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("Nombre","titulo","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Descripcion corta","bajada","","\\\\.","",80,4,false,"requerida.");
$abm->addRichText("Detalle","descripcion","",400);
$abm->addFoto("Foto","foto","","../imagenes/servicios/fotos/");
$abm->addTextField("Estilo CSS","estilo","","\\\\.","",20,0,true,"Estilo CSS es requerido.");
//$abm->addCheckBox("Newsletters","newsletters",1);
$abm->addCheckBox("Activo","activo",1);
//$abm->addCheckBox("Home","home",1);

$abm->show();
?>