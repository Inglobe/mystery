<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"encuestas","encuestas","id_encuesta","Sistema","Encuestas","SELECT * FROM encuestas",20);

$abm->addFilter("textField","descripcion_es","Descripci&oacute;n",60);

$abm->addCol("descripcion_es","descripcion_es","Descripci&oacute;n",200,"left","left",true);

$abm->addButtonCol("preguntas_search.pop.php","imagenes/btn_preguntas.gif","Preguntas",700,400);
$abm->addRelacion("preguntas","id_encuesta");

$abm->show();
?>