<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"videos","videos","id_video","Sitio","Videos",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Nombre","nombre","","\\\\.","",70,0,true,"Nombre es requerido.");
$abm->addRichText("Descripci&oacute;n","descripcion","",400);
$abm->addFoto("Vista previa","foto","","../imagenes/videos/fotos/");
$abm->addTextField("Youtube URL","youtube_url","","\\\\.","",80,0,true,"Nombre es requerido.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>