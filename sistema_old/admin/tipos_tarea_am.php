<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"tipos_tarea","tipos_tarea","id_tipo_tarea","Proyectos","Tipos de tareas",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",40,0,true,"Descripci&oacute;n es requerida.");

$abm->show();
?>