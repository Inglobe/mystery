
<?php

	require_once(PATH_ABM_SEARCH);
	
	$sql = "SELECT 
				*
			FROM 
				groups
			";
	
	$abm = new ABMSearch("groups","groups","id_group","Sistema","Grupos",$sql);
	
	//filtros
	$abm->addFilter("textField","description","Descripci&oacute;n",32);
	
	//Listado
	$abm->addCol("description","description","Descripci&oacute;n",200,"left","left",true);
	
	$abm->show();
?>
