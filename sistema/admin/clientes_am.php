<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"clientes","clientes","id_cliente","Sistema","Clientes",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Nombre","nombre","","\\\\.","",40,0,true,"Nombre es requerido.");
$abm->addTextField("E-mail","email","","\\\\.","",40,0,true,"E-mail es requerido.");
$abm->addTextArea("Tel&eacute;fonos","telefonos","","\\\\.","",80,4,false,"requerida.");
$abm->addTextField("Domicilio","domicilio","","\\\\.","",60,0,false,"es requerido.");
$abm->addTextField("Localidad","localidad","","\\\\.","",30,0,false,"es requerido.");
$abm->addTextField("Provincia","provincia","","\\\\.","",30,0,false,"es requerido.");
$abm->addCombo("Tipo identificaci&oacute;n","id_tipo_identificacion",$link,"SELECT * FROM tipos_identificacion ORDER BY id_tipo_identificacion ASC","id_tipo_identificacion","descripcion",0,"--seleccionar--",false,"Seleccione tipo de identificación.");
$abm->addTextField("Identificaci&oacute;n","identificacion","","\\\\.","",14,0,false,"es requerido.");
$abm->addFoto("Logo","logo","","../imagenes/clientes/logos/");
$abm->addTextArea("Observaciones","obs","","\\\\.","",80,4,false,"requerida.");

$abm->show();
?>