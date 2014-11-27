<?php
require("clases/ABMSearch.class.php");

$consulta = "SELECT
					c.*,
					DATE_FORMAT(c.valida_desde,'%d/%m/%Y') AS valida_desde_f,
					DATE_FORMAT(c.valida_hasta,'%d/%m/%Y') AS valida_hasta_f,
					u.nombre,
					u.apellido
				FROM
					credenciales c,
					usuarios u
				WHERE
					c.id_usuario = u.id_usuario
			";
$abm = new ABMSearch($link,"credenciales","credenciales","id_credencial","Sistema","Credenciales",$consulta,$paginacion);

//Filtros
$abm->addFilter("textField","u.nombre","Nombre",40);
$abm->addFilter("textField","u.apellido","Apellido",40);
//Listado
$abm->addCol("c.valida_desde","valida_desde_f","Valida desde",100,"left","left",true);
$abm->addCol("c.valida_hasta","valida_hasta_f","Valida hasta",200,"left","left",true);
$abm->addCol("u.nombre","nombre","Nombre",200,"left","left");
$abm->addCol("u.apellido","apellido","Apellido",200,"left","left");

$abm->addButtonCol("../credenciales/credencial.print.php","imagenes/ico_print.gif","Imprimir Credencial",580,400);

//Relaciones

$abm->show();
?>