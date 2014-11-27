<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"articulos","articulos","id_articulo","Sitio","Art&iacute;culos","SELECT * FROM news",20);
//Filtros
$abm->addFilter("textField","titulo","T&iacute;tulo",40);
//Listado
$abm->addCol("titulo","titulo","T&iacute;tulo",200,"left","left",true);

$abm->show();
?>