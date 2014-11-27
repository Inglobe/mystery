<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"links","links","id_link","Sitio","Links de inter&eacute;s","SELECT * FROM links",$paginacion);

$abm->setCampoOrden("orden");

$abm->addFilter("textField","titulo","T&iacute;tulo",40);

$abm->addCol("titulo","titulo","T&iacute;tulo",200,"left","left",false);

$abm->show();
?>