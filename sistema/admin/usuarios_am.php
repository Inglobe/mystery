<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"usuarios","usuarios","id_usuario","Sitio","Usuarios",$_GET["abm_accion"],$_GET["id"],false);

$abm->addCombo("Tipo","id_tipo_usuario",$link,"SELECT * FROM tipos_usuarios ORDER BY id_tipo_usuario ASC","id_tipo_usuario","nombre",0,"--seleccionar--",false,"Seleccione tipo de usuario.");
$abm->addTextField("Nombre","nombre","","\\\\.","",40,0,true,"Nombre es requerido.");
$abm->addTextArea("Tel&eacute;fonos","telefonos","","\\\\.","",80,4,false,"requerida.");
$abm->addTextField("Domicilio","domicilio","","\\\\.","",40,0,false,"es requerido.");
$abm->addTextField("E-mail","email","","\\\\.","",40,0,true,"E-mail es requerido.");
$abm->addTextField("Usuario","user","","\\\\.","",40,0,true,"Nombre de usuario es requerido.");
$abm->addPassField("Pass","pass","","\\\\.","",40,0,true,"Contrase&ntilde;a es requerido.");
$abm->addFoto("Foto","foto","","../imagenes/usuarios/fotos/");
$abm->addCheckBox("Activo","activo",1);
//$abm->addCheckBox("Usuario externo","usuario_externo",1);

$abm->show();
?>