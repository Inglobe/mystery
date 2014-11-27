<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"resellers","resellers","id_reseller","Hosting","Resellers","SELECT * FROM resellers",$paginacion);
//Filtros
$abm->addFilter("textField","nombre","Nombre",40);
//Listado
$abm->addCol("nombre","nombre","Nombre",200,"left","left",true);
$abm->addCol("email_soporte","email_soporte","E-mail de soporte",200,"left","left",true);
$abm->addCol("user","user","Usuarios",200,"left","left",true);
$abm->addCol("pass","pass","Contrase&ntilde;a",200,"left","left",true);
$abm->addButtonCol("planes_search.pop.php","imagenes/btn_planes.jpg","Planes",660,400);

$abm->show();
?>