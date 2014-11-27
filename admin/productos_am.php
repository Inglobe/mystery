<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"productos","productos","id_producto","Sitio","Productos",$_GET["abm_accion"],$_GET["id"],false);

//Combo categorias
$abm->addCombo("Categor&iacute;a","id_categoria",$link,"SELECT * FROM categorias_productos WHERE activo = 1 ORDER BY id_categoria ASC","id_categoria","descripcion",0,"--seleccionar--",true,"Categoría es requerida.");
$abm->addCombo("Marca","id_marca",$link,"SELECT * FROM marcas WHERE activo = 1 ORDER BY descripcion ASC","id_marca","descripcion",0,"--seleccionar--",true,"Marca es requerida.");

//
$abm->addTextField("Nombre","nombre","","\\\\.","",80,0,false,"requerido.");
$abm->addTextArea("Descripci&oacute;n corta","descripcion_corta","","\\\\.","",60,4,false,"requerida.");
$abm->addRichText("Detalle","detalle","","400");
$abm->addFile("Archivo","archivo","","../downloads/");

//$tmp_moneda=mysql_fetch_array(mysql_query("SELECT * FROM monedas WHERE referencia = 1",$link));

//$abm->addTextField("Precio (".$tmp_moneda["descripcion"].")","precio","","\\\\.","",10,0,false,"requerido.");
//$abm->addCheckBox("Mostrar Precio","mostrar_precio",1);

/*ob_start();
require("productos_am_check_list.inc.php");
$html_check_list=ob_get_contents();
ob_end_clean();
$abm->addHTML("Características",$html_check_list);*/

/*if($_GET["abm_accion"] == "a"){
	ob_start();
	require("gallery_add.inc.php");
	$html_fotos=ob_get_contents();
	ob_end_clean();
	$abm->addHTML("Fotos",$html_fotos);
}*/

//$abm->addCheckBox("Nuevo","nuevo",0);
//$abm->addCombo("Estado","id_estado",$link,"SELECT * FROM estados ORDER BY id_estado ASC","id_estado","descripcion",0,"--seleccionar--",true,"Estado es requerida.");
//$abm->addCheckBox("Oferta","oportunidad",0);
//$abm->addCheckBox("Home","home",1);
$abm->addCheckBox("Activo","activo",1);
$abm->addCheckBox("Newsletters","newsletters",0);

$abm->show();
?>