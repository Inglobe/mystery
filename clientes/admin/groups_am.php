<?
	require(PATH_ABM_ADDEDIT);
	
	$abm = new ABMAddEdit("groups","groups","id_group","Sistema","Grupos",$data->get('abm_accion'),$data->get('id',DATA_EX_TYPE_INT,false),false);
	
	$abm->addTextField("Descripci&oacute;n","description","","\\\\.","",40,0,true,"Descripci&oacute;n es requerido.");
	$abm->addCheckBox("Activo","enabled",0);
	
	$abm->show();
?>