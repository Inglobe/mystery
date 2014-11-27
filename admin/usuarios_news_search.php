<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"usuarios_news","usuarios_news","id_usuario_news","Newsletters","Suscriptos","SELECT f.*, s.descripcion AS grupo FROM usuarios_news f, grupos_news s WHERE f.id_grupo_news = s.id_grupo_news",20);

ob_start();
require("usuarios_news_search_importar_exportar.inc.php");
$html_importar = ob_get_contents();
ob_end_clean();
$abm->addHTML($html_importar);

//Filtros
$abm->addFilter("textField","f.email","Email",40);
$abm->addFilter("textField","f.nombre","Nombre",40);
$abm->addFilter("combo","s.id_grupo_news","Seccion",0,"SELECT s.* FROM grupos_news s ORDER BY s.descripcion ASC","descripcion","--todos--");

//Listado
$abm->addCol("f.email","email","Email",200,"left","left",true);
$abm->addCol("f.nombre","nombre","Nombre",200,"left","left",true);
$abm->addCol("f.telefono","telefono","Tel&eacute;fono",200,"left","left",true);
$abm->addCol("s.descripcion","grupo","Grupo",200,"left","left",true);

$abm->show();
?>