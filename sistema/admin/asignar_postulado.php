<?
	$sql = "UPDATE proyectos SET id_usuario_responsable = ".$_GET["id_usuario"]." WHERE id_proyecto = ".$_GET["id_proyecto"];
	mysql_query($sql,$link);
	echo mysql_error($link);
	
	$sql = "UPDATE tareas SET id_usuario_responsable = ".$_GET["id_usuario"]." WHERE id_proyecto = ".$_GET["id_proyecto"];
	mysql_query($sql,$link);
	echo mysql_error($link);
	
	$sql = "DELETE FROM postulaciones WHERE id_proyecto = ".$_GET["id_proyecto"];
	mysql_query($sql,$link);
	echo mysql_error($link);
?>
<div id="contenedor_loading">
  <div id="loading">Please Wait...<br />
  <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script type="text/javascript">
// <![CDATA[
	setTimeout('redireccionar("index.php?put=proyectos_postulaciones")', 1500);
// ]]>
</script>