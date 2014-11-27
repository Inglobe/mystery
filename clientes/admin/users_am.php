<?
	require(PATH_ABM_ADDEDIT);
	
	$abm = new ABMAddEdit("users","users","id_user","Sistema","Usuarios",$data->get('abm_accion'),$data->get('id',DATA_EX_TYPE_INT,false),false);
	
	$abm->addTextField("Nombre","name","","\\\\.","",40,0,true,"Nombre es requerido.");
	$abm->addTextField("Apellido","last_name","","\\\\.","",40,0,true,"Apellido es requerido.");
	$abm->addTextField("E-mail","email","","\\\\.","",40,0,true,"E-mail es requerido.");
	$abm->addTextField("Usuario","user","","\\\\.","",20,0,true,"Nombre de usuario es requerido.");
	$abm->addPassField("Contrase&ntilde;a","pass","");
	$abm->addFoto("Foto","photo","","../images/usuarios/fotos/");
	$abm->addCheckBox("Admin","admin",0);
	
	$abm->show();
?>