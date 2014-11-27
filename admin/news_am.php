<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"news","news","id_new","Sitio","Novedades",$_GET["abm_accion"],$_GET["id"],false);

//Combo secciones
//$abm->addCombo("Secciones","id_seccion",$link,"SELECT * FROM news_secciones ORDER BY descripcion ASC","id_seccion","descripcion",0,"--seleccionar--",true,"Seccion es requerida.");
//Combo Categorias
$abm->addCombo("Categorias","id_categoria",$link,"SELECT * FROM categorias ORDER BY descripcion ASC","id_categoria","descripcion",0,"--seleccionar--",true,"Categoría es requerida.");
//
$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("T&iacute;tulo","titulo","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Bajada","bajada","","\\\\.","",80,4,false,"requerida.");
$abm->addRichText("Descripci&oacute;n","descripcion","",400);
$abm->addFoto("Foto","foto","","../imagenes/news/fotos/");
//$abm->addTextField("Precio","precio","","\\\\.","",20,0,false,"Titulo es requerido.");
//$abm->addFoto("Foto slide home","foto_home","","../imagenes/news/fotos/");
//$abm->addTextField("Link Slide","link_slide","","\\\\.","",60,0,false,"Titulo es requerido.");
//$abm->addTextArea("Epigrafe","epigrafe","","\\\\.","",40,3,false,"requerida.");
//$abm->addTextField("Orden","orden","","\\\\.","",2,0,false," es requerido.");
//$abm->addCombo("Relacionado con","relacion_sucursal",$link,"SELECT * FROM sucursales ORDER BY titulo ASC","id_sucursal","titulo",0,"--Todas las sucursales--",false,"Seccion es requerida.");
//$abm->addCheckBox("Home","home",0);
$abm->addCheckBox("Activo","activo",1);
//$abm->addCheckBox("Calendario","calendario",0);
//$abm->addCheckBox("Newsletter","newsletters",1);

/*ob_start();
require("news_am_checklist.inc.php");
$html_check_list=ob_get_contents();
ob_end_clean();
$abm->addHTML("Galer&iacute;as",$html_check_list);*/

$abm->show();
?>