<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"proveedores","proveedores","id_proveedor","Sistema","Proveedores",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Nombre","nombre","","\\\\.","",40,0,true,"Nombre es requerido.");
$abm->addTextField("E-mail","email","","\\\\.","",40,0,false,"E-mail es requerido.");
$abm->addTextArea("Tel&eacute;fonos","telefonos","","\\\\.","",80,4,false,"requerida.");
$abm->addTextField("Domicilio","domicilio","","\\\\.","",40,0,false,"es requerido.");

$abm->show();
?>