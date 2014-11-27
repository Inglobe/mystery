<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"grupos_news","grupos_news","id_grupo_news","Newsletters","Grupos Suscriptos","SELECT * FROM grupos_news",20);

$abm->addFilter("textField","descripcion","Descripci&oacute;n",60);
$abm->addCol("descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);
//Relaciones
$abm->addRelacion("usuarios_news","id_grupo_news");

$abm->show();
?>