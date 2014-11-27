<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"usuarios","usuarios","id_usuario","Sistema","Usuarios",$_GET["abm_accion"],$_GET["id"],false);

$abm->addTextField("Nombre","nombre","","\\\\.","",80,0,true,"Nombre es requerido.");
$abm->addTextField("Apellido","apellido","","\\\\.","",80,0,true,"Apellido es requerido.");
$abm->addTextField("Apodo","apodo","","\\\\.","",80,0,false,"es requerido.");
$abm->addTextField("E-mail","email","","\\\\.","",80,0,true,"E-mail es requerido.");
$abm->addTextField("DNI - CUIT/CUIL","dni","","\\\\.","",10,0,false,"E-mail es requerido.");
$abm->addDate("Fecha de nacimiento","fecha_nacimiento",date("Y-m-d",time()));
$abm->addDate("Fecha de ingreso","fecha_ingreso",date("Y-m-d",time()));
$abm->addTextField("Domicilio","domicilio","","\\\\.","",80,0,false,"es requerido.");
$abm->addTextField("Localidad","localidad","","\\\\.","",80,0,false,"es requerido.");
$abm->addTextField("Provincia","provincia","","\\\\.","",80,0,false,"es requerido.");
$abm->addTextField("Tel&eacute;fono","telefono","","\\\\.","",60,0,false,"es requerido.");
$abm->addTextField("Celular","celular","","\\\\.","",30,0,false,"es requerido.");
$abm->addTextField("Cargo","cargo","","\\\\.","",80,0,false,"es requerido.");
$abm->addTextArea("Intereses","intereses","","\\\\.","",50,4,false,"requerida.");
$abm->addTextField("Hincha","hincha","","\\\\.","",50,0,false,"es requerido.");
$abm->addTextArea("Frase celebre","frase_celebre","","\\\\.","",50,4,false,"requerida.");
$abm->addCheckBox("Usa Facebook","facebook",0);
$abm->addCombo("Sexo","id_sexo",$link,"SELECT * FROM sexo ORDER BY descripcion ASC","id_sexo","descripcion",0,"--seleccionar--",true,"Seleccione sexo.");
$abm->addTextField("Estado civil","estado_civil","","\\\\.","",20,0,false,"es requerido.");
$abm->addFoto("Foto","foto","","../imagenes/usuarios/fotos/");
$abm->addCombo("Contacto responsable","id_usuario_responsable",$link,"SELECT *, CONCAT(nombre,' ',apellido) AS nombre_usuario FROM usuarios ORDER BY nombre_usuario ASC","id_usuario","nombre_usuario",0,"--seleccionar--",false,"Seleccione sexo.");
$abm->addTextField("Nombre de usuario","user","","\\\\.","",40,0,true,"Nombre de usuario requerido.");
$abm->addPassField("Contrase&ntilde;a","pass","","\\\\.","",40,0,false,"es requerido.");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>