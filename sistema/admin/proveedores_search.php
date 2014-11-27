<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"proveedores","proveedores","id_proveedor","Sistema","Proveedores","SELECT * FROM proveedores",$paginacion);
//Filtros
$abm->addFilter("textField","nombre","Nombre",40);
$abm->addFilter("textField","email","E-mail",40);
//Listado
$abm->addCol("nombre","nombre","Nombre",200,"left","left",true);
$abm->addCol("email","email","E-mail",200,"left","left",true);
$abm->addCol("telefonos","telefonos","Tel&eacute;fono",200,"left","left",true);
$abm->addButtonCol("pagos_search.pop.php","imagenes/btn_pagos.jpg","Pagos",660,400);

$abm->show();
?>