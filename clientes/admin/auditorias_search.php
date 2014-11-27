<?php
require_once(PATH_ABM_SEARCH);

$db_tmp = new database;
$db_tmp->query("SELECT id_cliente FROM contactos WHERE id_contacto = ".$_SESSION["id_usr"]);
$db_tmp->fetch();

$sql = "SELECT 
			p.*,
			s.nombre AS sucursal
		FROM 
			proyectos p
			JOIN sucursales s ON p.id_sucursal = s.id_sucursal
		WHERE 
			p.id_cliente = ".$db_tmp->getValue("id_cliente")." AND
			p.id_estado_proyecto = 3 AND
			p.plantilla = 0
	";

$abm = new ABMSearch("auditorias","proyectos","id_proyecto","Sistema","Caracteristicas",$sql,100,false);

$abm->readOnly = true;

$aux["id"] = "id_proyecto";

$abm->setCustomEdit("index.php?put=auditorias_informe", $aux);

//Filtros
$abm->addFilter("textField","p.nombre","Nombre",40);
$abm->addFilter("combo","p.id_sucursal","Sucursal",40,"SELECT * FROM sucursales WHERE id_cliente = ".$db_tmp->getValue("id_cliente"),"nombre","--todas--");
//Listado
$abm->addCol("nombre","nombre","Nombre",200,"left","left",true,"DESC");
$abm->addCol("nombre","sucursal","Sucursal",200,"left","left",false);


$abm->show();
?>