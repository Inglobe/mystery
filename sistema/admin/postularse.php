<?
	$sql = "INSERT INTO postulaciones (id_usuario, id_proyecto) VALUES('".$_SESSION["id_usr"]."','".$_GET["id"]."')";
	mysql_query($sql,$link);
	echo mysql_error($link);
?>
<div id="contenedor_loading">
  <div id="loading">Please Wait...<br />
  <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script type="text/javascript">
// <![CDATA[
	setTimeout('redireccionar("index.php?put=proyectos_disponibles")', 1500);
// ]]>
</script>