<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"planes","hosting_planes","id_plan","Hosting","Planes","SELECT * FROM hosting_planes",$paginacion);
//Filtros
$abm->addFilter("textField","descripcion","Descripci&oacute;n",40);
//Listado
$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);
$abm->show();
?>