<?php
require("clases/ABMSearch.class.php");

$consulta = "SELECT
					p.*,
					DATE_FORMAT(p.fecha,'%d/%m/%Y') AS fecha_f,
					c.descripcion AS categoria
				FROM
					publicaciones p,
					categorias c
				WHERE
					p.id_categoria = c.id_categoria
			";

$abm = new ABMSearch($link,"publicaciones","publicaciones","id_publicacion","Sistema","Publicaciones",$consulta,$paginacion);

$abm->setGaleria();
//Filtros
$abm->addFilter("date","p.fecha","Fecha",10);
$abm->addFilter("textField","p.titulo","T&iacute;tulo",40);
//Listado
$abm->addCol("c.descripcion","categoria","Categoria",100,"left","left",true,"DESC");
$abm->addCol("p.fecha","fecha_f","Fecha",100,"left","left",true,"DESC");
$abm->addCol("p.titulo","titulo","T&iacute;tulo",200,"left","left");

//$amb->addButtonCol("../newsletters/index.php","imagenes/btn_preview_noticia.gif","Previsualizar",800,450);

//Relaciones

$abm->show();
?>