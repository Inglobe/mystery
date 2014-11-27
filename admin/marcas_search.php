<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"marcas","marcas","id_marca","Sitio","Marcas","SELECT * FROM marcas",20);

$abm->setCampoOrden("orden");

//Filtros
$abm->addFilter("textField","descripcion","Descripci&oacute;n",40);
//Listado
$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",false);
//Relaciones
$abm->addRelacion("productos","id_marca");

$abm->show();
?>