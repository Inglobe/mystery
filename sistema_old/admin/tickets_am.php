<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"tickets","tickets_hosting","id_ticket_hosting","Hosting","Tickets",$_GET["abm_accion"],$_GET["id"],false);

$abm->addDate("Fecha de emision","fecha",date("Y-m-d",time()));
$abm->addDate("Fecha de alta","fecha_alta",date("Y-m-d",time()));
$abm->addCombo("Cliente","id_cliente",$link,"SELECT * FROM clientes ORDER BY nombre ASC","id_cliente","nombre",0,"--seleccionar--",true,"Seleccione cliente.");
$abm->addCombo("Plan","id_plan",$link,"SELECT * FROM hosting_planes ORDER BY descripcion ASC","id_plan","descripcion",0,"--seleccionar--",true,"Seleccione plan.");
$abm->addTextField("Dominio","dominio","","\\\\.","",80,200,true,"Dominio es requerido");
$abm->addTextField("Monto","monto","","\\\\.","",10,10,true,"Monto es requerido");
$abm->addDate("Fecha de vencimiento","fecha_vencimiento",date("Y-m-d",time()));
$abm->addCombo("Método de pago","id_metodo_pago",$link,"SELECT * FROM metodos_pago ORDER BY id_metodo_pago ASC","id_metodo_pago","descripcion",1,"--seleccionar--",true,"Seleccione método de pago.");
$abm->addCombo("Estado","id_estado_ticket",$link,"SELECT * FROM estados_tickets ORDER BY id_estado_ticket ASC","id_estado_ticket","descripcion",1,"--seleccionar--",true,"Seleccione estado.");
$abm->addTextField("Nro Comprobante","numero_comprobante","","\\\\.","",10,100,false,"");
$abm->addTextField("Fecha de informe","fecha_informe","","\\\\.","",10,100,false,"");
$abm->addRichText("Detalle","detalle","",400);
$abm->addCheckBox("Renovar","renovar",1);

$abm->show();
?>
<script type="text/javascript" src="js_library/tickets_am.js"></script>