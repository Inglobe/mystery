<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"tipos_tarea","tipos_tarea","id_tipo_tarea","Proyectos","Tipos de tareas","SELECT * FROM tipos_tarea",$paginacion);
//Filtros
$abm->addFilter("textField","descripcion","Descripci&oacute;n",40);
//Listado
$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);

$abm->show();
?>