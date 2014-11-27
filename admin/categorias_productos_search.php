<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"categorias_productos","categorias_productos","id_categoria","Sitio","Categor&iacute;as","SELECT * FROM categorias_productos",20);

$abm->setCampoOrden("orden");

//Filtros
$abm->addFilter("textField","descripcion","Descripci&oacute;n",40);
//Listado
$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);
//Relaciones
$abm->addRelacion("productos","id_categoria");

$abm->show();
?>