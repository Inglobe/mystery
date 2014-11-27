<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"usuarios_news","usuarios_news","id_usuario_news","Sitio","Usuarios Suscriptos",$_GET["abm_accion"],$_GET["id"],false);

$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addCombo("Grupo","id_grupo_news",$link,"SELECT * FROM grupos_news ORDER BY id_grupo_news ASC","id_grupo_news","descripcion",0,"--seleccionar--",true,"Seleccione grupo.");
$abm->addTextField("Nombre","nombre","","\\\\.","",40,0,true,"Nombre es requerido.");
$abm->addTextField("Telefono","telefono","","\\\\.","",40,0,false,"Telefono es requerido.");
$abm->addTextField("E-mail","email","","\\\\.","",40,0,false,"E-mail es requerido.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>