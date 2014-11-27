<?php

	require_once(PATH_ABM_SEARCH);
	
	$abm = new ABMSearch("properties","inmuebles","id_inmueble","Sistema","Inmuebles","SELECT * FROM inmuebles");
	
	//filtros
	$abm->addFilter("textField","name","Nombre",32);
	
	//Listado
	$abm->addCol("nombre","nombre","Nombre",200,"left","left",true);
	//$abm->addCol("last_name","last_name","Apellido",200,"left","left",true);
	
	$abm->show();
?>