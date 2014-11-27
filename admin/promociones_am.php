<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"promociones","promociones","id_promocion","Sitio","Promociones",$_GET["abm_accion"],$_GET["id"],false);

$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("Titulo","titulo","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Bajada","bajada","","\\\\.","",80,4,false,"requerida.");
$abm->addRichText("Descripci&oacute;n","descripcion","",400);
$abm->addFoto("Foto","foto","","../imagenes/news/fotos/");
$abm->addCheckBox("Newsletters","newsletters",1);
$abm->addCheckBox("Activo","activo",1);
$abm->addCheckBox("Home","home",1);

$abm->show();
?>