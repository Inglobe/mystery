<?php
require_once(PATH_ABM_SEARCH);
	
$abm = new ABMSearch("inmuebles_categorias","inmuebles_categorias","id_categoria","Sistema","Tipos de inmuebles","SELECT * FROM inmuebles_categorias");
$abm->setCampoOrden("orden");
//
$abm->addFilter("textField","titulo","Titulo",60);
$abm->addCol("titulo","titulo","Nombre",200,"left","left",true);
//Relaciones
//$abm->addRelacion("inmuebles","id_categoria");

$abm->show();
?>