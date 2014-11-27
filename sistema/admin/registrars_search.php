<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"registrars","registrars","id_registrar","Hosting","Registrars","SELECT * FROM registrars",$paginacion);
//Filtros
$abm->addFilter("textField","descripcion","Descripci&oacute;n",40);
//Listado
$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);
$abm->show();
?>