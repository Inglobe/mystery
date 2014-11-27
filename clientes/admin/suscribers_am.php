<?
	require(PATH_ABM_ADDEDIT);
	
	$abm = new ABMAddEdit("suscribers","suscribers","id_suscriber","Sistema","Suscriptores",$data->get('abm_accion'),$data->get('id',DATA_EX_TYPE_INT,false),false);
	
	$abm->addCombo("Grupo","id_group","SELECT * FROM groups ORDER BY description ASC","id_group","description",0,"--seleccionar--",true,"Seleccione grupo.");
	$abm->addTextField("Nombre","name","","\\\\.","",40,0,true,"Nombre es requerido.");
	$abm->addTextField("E-mail","email","","\\\\.","",40,0,true,"E-mail es requerido.");
	$abm->addTextField("Tel&eacute;fono","tel","","\\\\.","",40,0,false," es requerido.");
	$abm->addTextField("Custom 0","custom_0","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 1","custom_1","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 2","custom_2","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 3","custom_3","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 4","custom_4","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 5","custom_5","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 6","custom_6","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 7","custom_7","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 8","custom_8","","\\\\.","",80,0,false," es requerido.");
	$abm->addTextField("Custom 9","custom_9","","\\\\.","",80,0,false," es requerido.");
	$abm->addCheckBox("Activo","enabled",0);
	
	$abm->show();
?>