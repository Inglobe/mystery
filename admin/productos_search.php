<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"productos","productos","id_producto","Sitio","Productos","
SELECT vm.*, vm.descripcion AS categoria, m.descripcion AS marca, v.id_producto, v.nombre, v.precio FROM
categorias_productos vm, marcas m, productos v
WHERE vm.id_categoria = v.id_categoria AND m.id_marca = v.id_marca",$paginacion);

$abm->setGaleria();
//Filtros
$abm->addFilter("textField","v.nombre","Descripci&oacute;n",40);
$abm->addFilter("combo","vm.id_categoria","Categor&iacute;a",0,"SELECT vm.* FROM categorias_productos vm ORDER BY vm.descripcion ASC","descripcion","--todos--");
$abm->addFilter("combo","m.id_marca","Marcas",0,"SELECT m.* FROM marcas m ORDER BY m.descripcion ASC","descripcion","--todas--");
//Listado
$abm->addCol("v.nombre","nombre","Nombre",200,"left","left",true);
$abm->addCol("vm.descripcion","categoria","Categor&iacute;as",120,"left","left",true);
$abm->addCol("m.descripcion","marca","Marcas",120,"left","left",true);
//$abm->addCol("v.precio","precio","Precio",200,"left","left",true);

$abm->show();
?>