<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"news_categorias","news_categorias","id_categoria","Sitio","Categor�as","SELECT * FROM news_categorias",$paginacion);

$abm->addFilter("textField","nombre","Nombre",40);
//Listado
$abm->addCol("descripcion","descripcion","Descripc�on",400,"left","left",true);
//Relaciones
$abm->addRelacion("news","id_categoria");

$abm->show();
?>