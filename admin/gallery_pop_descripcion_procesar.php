<?
	require "procesos_globales.php";

	mysql_query("UPDATE fotos SET descripcion = '".$_POST["descripcion"]."' WHERE id_foto = ".$_GET["id"],$link);
	echo mysql_error($link);
?>
    <div id="contenido">
      <table width="100%" border="0" cellspacing="50" cellpadding="0">
        <tr>
          <td align="center"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/please_wait.gif" alt="please wait" /></td>
        </tr>
      </table>
    </div>
    <script src="../includes/funciones_generales.js" type="text/javascript"></script>
    <script language="JavaScript">
	<!--
		function cerrar_ventana(url) {
			opener.location.href=url;
			window.close();
		}
		setTimeout('cerrar_ventana("gallery_pop.php?id_relacion=<?=$_GET["id_relacion"]?>&nombre_abm=<?=$_GET["nombre_abm"]?>")', 1500);
	//-->
	</script>