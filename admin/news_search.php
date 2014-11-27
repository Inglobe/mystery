<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"news","news","id_new","Sitio","Novedades","SELECT n.*, DATE_FORMAT(n.fecha,'%d/%m/%Y') AS fecha_f, c.descripcion AS categoria FROM news n, categorias c WHERE c.id_categoria = n.id_categoria",$paginacion);

//$abm->setGaleria();
//Filtros
$abm->addFilter("date","fecha","Fecha",10);
$abm->addFilter("textField","titulo","T&iacute;tulo",40);
//Combo Categorias News
$abm->addFilter("combo","c.id_categoria","Categor&iacute;a",0,"SELECT c.* FROM categorias c ORDER BY c.descripcion ASC","descripcion","--todas--");
//Listado
$abm->addCol("fecha","fecha_f","Fecha",100,"left","left",true);
$abm->addCol("titulo","titulo","T&iacute;tulo",200,"left","left",true);
$abm->addCol("c.descripcion","categoria","Categor&iacute;a",100,"left","left",true);
//$abm->setCampoOrden("orden");

$abm->show();
?>