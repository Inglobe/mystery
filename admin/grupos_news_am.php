<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"grupos_news","grupos_news","id_grupo_news","Sitio","Grupos Suscriptos",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",70,0,true,"Descripcion es requerida.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>