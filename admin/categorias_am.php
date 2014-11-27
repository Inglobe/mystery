<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"categorias","categorias","id_categoria","Sitio","Categor&iacute;as",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",80,0,true,"Descripción requerida.");
//$abm->addCombo("Tipo de publicaci&oacute;n","id_tipo_publicacion",$link,"SELECT * FROM tipos_publicaciones ORDER BY descripcion ASC","id_tipo_publicacion","descripcion",0,"--seleccionar--",true,"Seleccione tipo de publicacion.");
//$abm->addFile("Icono","icono","","../imagenes/categorias/icono/");
//$abm->addCombo("Tipo de categoria","id_tipo_categoria",$link,"SELECT * FROM tipos_categoria ORDER BY descripcion ASC","id_tipo_categoria","descripcion",0,"--seleccionar--",true,"Seleccione el tipo.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>