<?
require(PATH_ABM_ADDEDIT);
	
$abm = new ABMAddEdit("caracteristicas","caracteristicas","id_caracteristica","Sistema","Caracteristicas",$data->get('abm_accion'),$data->get('id',DATA_EX_TYPE_INT,false),false);

$sql_cmb = "SELECT 
				cc.id_cat_caracteristica,
				CONCAT(ic.titulo, ' / ', cc.descripcion) AS descripcion
			FROM 
				cat_caracteristicas cc
				JOIN inmuebles_categorias ic ON cc.id_inmueble_categoria = ic.id_categoria
			ORDER BY 
				descripcion ASC";
$abm->addCombo("Categor&iacute;a","id_cat_caracteristica",$sql_cmb,"id_cat_caracteristica","descripcion",0,"--seleccionar--",true,"Categoría es requerida.");
$abm->addTextField("Descripci&oacute;n","descripcion","","\\\\.","",80,0,true,"Descripción requerida.");
//$abm->addFile("Icono","icono","","../imagenes/iconos/");

$abm->show();
?>