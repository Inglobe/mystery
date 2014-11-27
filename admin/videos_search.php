<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"videos","videos","id_video","Sitio","Videos","SELECT * FROM videos",$paginacion);

$abm->addFilter("textField","nombre","Nombre",40);
//Listado
$abm->addCol("nombre","nombre","Nombre",400,"left","left",true);

$abm->show();
?>