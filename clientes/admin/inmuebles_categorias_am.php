<?
require(PATH_ABM_ADDEDIT);
	
$abm = new ABMAddEdit("inmuebles_categorias","inmuebles_categorias","id_categoria","Sistema","Tipos de inmuebles",$data->get('abm_accion'),$data->get('id',DATA_EX_TYPE_INT,false),false);

$abm->addTextField("T&iacute;tulo","titulo","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Descripci&oacute;n","descripcion","","\\\\.","",80,4,false,"requerida.");
$abm->addFoto("Foto","foto","","../imagenes/inmuebles/categorias/");
//$abm->addFile("Archivo","file","","../imagenes/inmuebles/categorias/");
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>