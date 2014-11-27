<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"agenda","agenda","id_agenda","Sitio","Calendario","SELECT *, DATE_FORMAT(fecha,'%d/%m/%Y') AS fecha_f FROM agenda",$paginacion);

$abm->setGaleria();

//Filtros
$abm->addFilter("date","fecha","Fecha",10);
$abm->addFilter("textField","titulo","T&iacute;tulo",40);
//Listado
$abm->addCol("fecha","fecha_f","Fecha",100,"left","left",true);
$abm->addCol("titulo","titulo","T&iacute;tulo",200,"left","left",true);
//Relaciones

$abm->show();
?>