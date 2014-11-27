<?php
require_once(PATH_ABM_SEARCH);

$sql = "SELECT 
			c.*, 
			cc.descripcion AS categoria_caracteristica,
			ic.titulo AS categoria
		FROM 
			caracteristicas c 
			JOIN cat_caracteristicas cc ON c.id_cat_caracteristica = cc.id_cat_caracteristica
			JOIN inmuebles_categorias ic ON cc.id_inmueble_categoria = ic.id_categoria
	";

$abm = new ABMSearch("caracteristicas","caracteristicas","id_caracteristica","Sistema","Caracteristicas",$sql);

//Filtros
$abm->addFilter("textField","ic.titulo","Categoria",40);
$abm->addFilter("textField","cc.descripcion","Cat caract",40);
$abm->addFilter("textField","c.descripcion","Descripci&oacute;n",40);
//Listado
$abm->addCol("categoria","categoria","Categoria",200,"left","left",true);
$abm->addCol("categoria_caracteristica","categoria_caracteristica","Categoria carcac.",200,"left","left",true);
$abm->addCol("descripcion","descripcion","Caracteristicas",200,"left","left",true);
//Relaciones
//$abm->addRelacion("vehiculos_modelos","id_marca");

$abm->show();
?>