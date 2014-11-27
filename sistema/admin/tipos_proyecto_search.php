<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"tipos_proyecto","tipos_proyecto","id_tipo_proyecto","Proyectos","Tipos de proyectos","SELECT * FROM tipos_proyecto",$paginacion);
//Filtros
$abm->addFilter("textField","descripcion","Descripci&oacute;n",40);
//Listado
$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);

$abm->show();
?>