<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"testimonios","testimonios","id_testimonio","Sitio","Testimonios","SELECT * FROM testimonios",20);
//Filtros
$abm->addFilter("textField","nombre_apellido","Nombre y apellido",40);
//Listado
$abm->addCol("nombre_apellido","nombre_apellido","Nombre y apellido",200,"left","left",true);

$abm->show();
?>