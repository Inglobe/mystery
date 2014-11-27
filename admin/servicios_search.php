<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"servicios","servicios","id_servicio","Sitio","Servicios","SELECT * FROM servicios",20);

$abm->setCampoOrden("orden");

//Filtros
$abm->addFilter("textField","titulo","Nombre",40);
//Listado
$abm->addCol("titulo","titulo","Nombre",200,"left","left",true);

$abm->show();
?>