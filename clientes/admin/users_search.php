<?php

	require_once(PATH_ABM_SEARCH);
	
	$abm = new ABMSearch("users","users","id_user","Sistema","Usuarios","SELECT * FROM users");
	
	//filtros
	$abm->addFilter("textField","name","Nombre",32);
	
	//Listado
	$abm->addCol("name","name","Nombre",200,"left","left",true);
	$abm->addCol("last_name","last_name","Apellido",200,"left","left",true);
	
	$abm->show();
?>