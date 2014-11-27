<?php
require("../includes/conexion.inc.php");
?>
<script type="text/javascript">
// <![CDATA[
	$$(".control").each(function(s,index){
		if(s.id!="cont_campo_id_categoria" && s.id!="cont_campo_activo"){
			s.hide();
		}
	});

<?
if(!isset($_POST["id_categoria"])){
	$_POST["id_categoria"] = 0;
}

$consulta = "SELECT
					tp.campos_mostrar
				FROM
					categorias c,
					tipos_publicaciones tp
				WHERE
					c.id_tipo_publicacion = tp.id_tipo_publicacion AND
					c.id_categoria = ".$_POST["id_categoria"]."
			";
$fila = mysql_fetch_assoc(mysql_query($consulta,$link));

$campos = explode(",",$fila["campos_mostrar"]);
foreach($campos as $campo){
	$campo = trim($campo);

	echo "	$('cont_campo_".$campo."').show();\n";
}

?>
// ]]>
</script>