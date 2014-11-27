<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"indices","indices","id_indice","Sitio","Indices","SELECT * FROM indices",20);

$abm->addFilter("textField","titulo","Titulo",40);
$abm->addCol("titulo","titulo","Titulo",200,"left","left",true);
//Relaciones


$abm->show();
?>