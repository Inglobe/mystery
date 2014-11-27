<?
require("clases/ABMAddEdit.class.php");

$abm = new ABMAddEdit($link,"publicaciones","publicaciones","id_publicacion","Sistema","Publicaciones",$_GET["abm_accion"],$_GET["id"],false);

//Combo Secciones
$abm->addCombo("Categoria","id_categoria",$link,"SELECT * FROM categorias ORDER BY descripcion ASC","id_categoria","descripcion",0,"--seleccionar--",true,"Seleccione categoria.");
$abm->addDate("Fecha","fecha",date("Y-m-d",time()));
$abm->addTextField("T&iacute;tulo","titulo","","\\\\.","",70,0,true,"Titulo es requerido.");
$abm->addTextArea("Bajada","bajada","","\\\\.","",80,4,false,"requerida.");
$abm->addRichText("Descripci&oacute;n","descripcion","",400);
$abm->addFoto("Foto","foto","","../imagenes/publicaciones/fotos/");
$abm->addCheckBox("Newsletter","newsletter",0);
$abm->addCheckBox("Newsletter interno","newsletter_interno",0);
$abm->addCheckBox("Home","home",0);
$abm->addCheckBox("Activo","activo",1);

$abm->show();
?>
<div id="updater_obj"><?
	if($_GET["abm_accion"] == "m"){

		$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT id_categoria FROM publicaciones WHERE id_publicacion =".$_GET["id"],$link));

		$_POST["id_categoria"] = $fila_tmp["id_categoria"];
	}
	include("get_tipo_publicacion.ajax.php")
?></div>
<script type="text/javascript" src="js_library/publicaciones_am.js"></script>