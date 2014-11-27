<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"usuarios","usuarios","id_usuario","Sistema","Usuarios","SELECT * FROM usuarios",20);
//Filtros
$abm->addFilter("textField","nombre","Nombre",32);
$abm->addFilter("textField","email","E-mail",32);
//Listado
$abm->addCol("nombre","nombre","Nombre",200,"left","left",true);
$abm->addCol("apellido","apellido","Apellido",200,"left","left",true);
$abm->addCol("telefono","telefono","Tel&eacute;fono",200,"left","left",true);
$abm->addCol("email","email","E-mail",200,"left","left",true);

$abm->show();

?>