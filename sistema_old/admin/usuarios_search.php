<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"usuarios","usuarios","id_usuario","Sitio","Usuarios","SELECT * FROM usuarios",20);
//Filtros
$abm->addFilter("textField","nombre","Nombre",32);
$abm->addFilter("textField","email","E-mail",32);
//Listado
$abm->addCol("nombre","nombre","Nombre",200,"left","left",true);
$abm->addCol("email","email","E-mail",200,"left","left",true);

$abm->addButtonCol("usuarios_logs_search.pop.php","imagenes/btn_logs.png","Historial",660,400);
//$abm->addButtonCol("reporte_horas_usuario.php","imagenes/ico_print.gif","Horas",1150,600);

$abm->show();

?>