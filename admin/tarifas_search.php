<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"tarifas","tarifas","id_tarifa","Sitio","Tarifas","SELECT l.*, cl.descripcion AS tipo FROM tarifas l, tipos_tarifas cl WHERE l.id_tipo_tarifa = cl.id_tipo_tarifa",50);
//Filtros
$abm->addFilter("textField","descripcion","Descripci&oacute;n",40);
$abm->addFilter("combo","cl.id_tipo_tarifa","Tipo",0,"SELECT cl.* FROM tipos_tarifas cl ORDER BY cl.descripcion ASC","descripcion","--todos--");
//Listado
$abm->addCol("l.descripcion","descripcion","Descripcion",400,"left","left",true);
$abm->addCol("cl.descripcion","tipo","Tipo",200,"left","left",true);
//Relaciones

$abm->show();
?>