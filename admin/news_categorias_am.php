<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"categorias","news_categorias","id_categoria","Sitio","Categorías",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripcion","descripcion","","\\\\.","",70,0,true,"Descripción es requerido.");

ob_start();
require("news_categorias_am_check_list.inc.php");
$html_check_list=ob_get_contents();
ob_end_clean();
$abm->addHTML("Secciones",$html_check_list);

$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>