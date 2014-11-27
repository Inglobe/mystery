<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"galerias","galerias","id_galeria","Sitio","Galerias","SELECT * FROM galerias",$paginacion);

$abm->readOnly=true;

$abm->setGaleria();

$abm->addFilter("textField","nombre","Nombre",40);
//Listado
$abm->addCol("nombre","nombre","Nombre",400,"left","left",true);
//Relaciones
$abm->addRelacion("fotos","id_relacion");

$abm->show();
?>