<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"resellers","resellers","id_reseller","Hosting","Resellers",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Nombre","nombre","","\\\\.","",40,0,true,"Nombre es requerido.");
$abm->addTextField("Nombre para cliente","nombre_para_clientes","","\\\\.","",40,0,true,"El nombre para cliente es requerido.");
$abm->addTextField("E-mail soporte","email_soporte","","\\\\.","",40,100,false,"");
$abm->addTextField("URL Panel","url_panel","","\\\\.","",80,255,false,"");
$abm->addTextField("IP","ip","","\\\\.","",16,16,false,"");
$abm->addTextField("Usuario","user","","\\\\.","",40,40,false,"");
$abm->addTextField("Contrase&ntilde;a","pass","","\\\\.","",40,40,false,"");
$abm->addTextArea("Observaciones","obs","","\\\\.","",80,7,false,"");

$abm->show();
?>