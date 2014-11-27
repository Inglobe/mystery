<?php
require_once(PATH_ABM_SEARCH);
	
$abm = new ABMSearch("cat_caracteristicas","cat_caracteristicas","id_cat_caracteristica","Sistema","Usuarios","SELECT cc.*, ic.titulo AS cat_inmueble FROM cat_caracteristicas cc JOIN inmuebles_categorias ic ON cc.id_inmueble_categoria = ic.id_categoria");
//$abm->setCampoOrden("orden");
//
$abm->addFilter("textField","descripcion","Descripcion",60);
$abm->addCol("descripcion","descripcion","Descripcion",200,"left","left",true);
$abm->addCol("cat_inmueble","cat_inmueble","Categoria",200,"left","left",true);
//Relaciones
$abm->addRelacion("caracteristicas","id_categoria");

$abm->show();
?>