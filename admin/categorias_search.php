<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"categorias","categorias","id_categoria","Sitio","Categor&iacute;as","SELECT * FROM categorias",20);
//Filtros
$abm->addFilter("textField","descripcion","Descripci&oacute;n",40);
//Listado
$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);
//Relaciones
$abm->addRelacion("publicaciones","id_categoria");

$abm->show();
?>