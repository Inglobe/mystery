
<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"clientes","clientes","id_cliente","Sistema","Clientes","SELECT * FROM clientes",$paginacion);
//Filtros
$abm->addFilter("textField","nombre","Nombre",40);
$abm->addFilter("textField","email","E-mail",40);
//Listado
$abm->addCol("nombre","nombre","Nombre",200,"left","left",true);
$abm->addCol("id_cliente","id_cliente","ID",70,"left","left",true);
$abm->addCol("email","email","E-mail",200,"left","left",true);
$abm->addButtonCol("contactos_search.pop.php","imagenes/btn_contacto.gif","Contactos",660,400);
$abm->addButtonCol("sucursales_search.pop.php","imagenes/btn_sucursales.gif","Sucursales",660,400);
$abm->addButtonCol("logs_search.pop.php","imagenes/btn_logs.png","Historial",660,400);

$abm->show();
?>