<?php
require("clases/ABMSearch.class.php");

$abm = new ABMSearch($link,"ordenes","ordenes","id_orden","Sistema","&Oacute;rdenes","
				SELECT
					o.*
					, c.nombre AS cliente
					, p.nombre AS proyecto
					, e.descripcion AS estado
				FROM
					ordenes o
					LEFT JOIN proyectos p ON (o.id_proyecto = p.id_proyecto)
					, clientes c
					, estados_ordenes e
				WHERE
					o.id_cliente = c.id_cliente
					AND o.id_estado_orden = e.id_estado_orden
				",$paginacion);
//Filtros
$abm->addFilter("textField","o.descripcion","Descripci&oacute;n",40);
$abm->addFilter("combo","c.id_cliente","Cliente",0,"SELECT c.* FROM clientes c ORDER BY c.nombre ASC","nombre","--todos--");
$abm->addFilter("combo","e.id_estado_orden","Estado",0,"SELECT e.* FROM estados_ordenes e ORDER BY e.id_estado_orden ASC","descripcion","--todos--");
//Listado
$abm->addCol("o.descripcion","descripcion","Descripci&oacute;n",200,"left","left",true);
$abm->addCol("c.nombre","cliente","Cliente",200,"left","left",true);
$abm->addCol("p.nombre","proyecto","Proyecto",200,"left","left",true);
$abm->addCol("e.descripcion","estado","Estado",100,"left","left",true);

$abm->show();
?>