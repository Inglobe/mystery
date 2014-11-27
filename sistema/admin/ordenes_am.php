<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"ordenes","ordenes","id_orden","Sistema","&Oacute;rdenes",$_GET["abm_accion"],$_GET["id"],false);

$abm->addCombo("Cliente","id_cliente",$link,"SELECT * FROM clientes ORDER BY nombre ASC","id_cliente","nombre",0,"--seleccionar--",true,"Seleccione cliente.");

ob_start();
require("ordenes_am.inc.php");
$html_proy=ob_get_contents();
ob_end_clean();
$abm->addHtml("Proyecto","<div id=\"cont_proyectos\">".$html_proy."</div>");

$abm->addCombo("Estado","id_estado_orden",$link,"SELECT * FROM estados_ordenes ORDER BY id_estado_orden ASC","id_estado_orden","descripcion",0,"--seleccionar--",true,"Seleccione estado.");

$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",40,0,true,"Descripcion es requerida.");
$abm->addTextArea("Detalle","detalle","","\\\\.","",80,4,false,"requerida.");
$abm->addTextField("Monto","monto","0.00","\\\\.","",10,10,false,"requerida.");

$abm->show();
?>
<script language="javascript" type="text/javascript" src="js_library/ordenes.js"></script>