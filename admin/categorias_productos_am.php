
<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"categorias_productos","categorias_productos","id_categoria","Sitio","Categor&iacute;as",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",80,0,true,"Descripción requerida.");
$abm->addRichText("Detalle","detalle","",400);
$abm->addFile("Foto","foto","","../imagenes/categorias/fotos/");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>