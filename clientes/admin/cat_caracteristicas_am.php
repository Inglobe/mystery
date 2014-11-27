<?
require(PATH_ABM_ADDEDIT);
	
$abm = new ABMAddEdit("cat_caracteristicas","cat_caracteristicas","id_cat_caracteristica","Sistema","Tipos de caracteristicas",$data->get('abm_accion'),$data->get('id',DATA_EX_TYPE_INT,false),false);

$abm->addCombo("Categor&iacute;as","id_inmueble_categoria","SELECT * FROM inmuebles_categorias ORDER BY titulo ASC","id_categoria","titulo",0,"--seleccionar--",true,"Categoría es requerida.");
$abm->addTextField("Descripcion","descripcion","","\\\\.","",70,0,true,"Descripcion es requerido.");
$abm->addCheckBox("Filtro en sitio","filtro_sitio",0);
$abm->addCheckBox("Filtro en home","filtro_home",0);

$abm->show();
?>