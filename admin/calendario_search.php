<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"calendario","calendario","id_calendario","Sitio","Calendario","SELECT * FROM calendario",20);
//Filtros
$abm->addFilter("textField","titulo","T&iacute;tulo",40);
//Listado
$abm->addCol("titulo","titulo","T&iacute;tulo",200,"left","left",true);

$abm->show();
?>