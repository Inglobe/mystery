<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"tipos_tarifas","tipos_tarifas","id_tipo_tarifa","Sitio","Tipos de tarifa","SELECT * FROM tipos_tarifas",20);

$abm->addFilter("textField","descripcion","Descripci&oacute;n",60);

$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);

$abm->addRelacion("links","id_categoria_link");

//Relacion
$abm->show();
?>