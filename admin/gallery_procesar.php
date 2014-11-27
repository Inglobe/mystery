<?
	require "procesos_globales.php";

	$path="../imagenes/galeria/fotos/";

	if(isset($_GET["id_eliminar"])){
		$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT foto FROM fotos WHERE id_foto = ".$_GET["id_eliminar"],$link));
		mysql_query("DELETE FROM fotos WHERE id_foto = ".$_GET["id_eliminar"],$link);
		unlink($path.$fila_tmp["foto"]);
	}
	else{
		$nom_archivo="foto";
		include("includes/agregar_foto.php");

		$ruta = $path.${"nombre_".$nom_archivo};
		require("includes/procesar_imagen.php");

		$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT (MAX(orden) + 1) AS nro FROM fotos where id_relacion = ".$_GET["id_relacion"]." AND abm = '".$_GET["nombre_abm"]."'",$link));
		echo mysql_error($link);

		$stringq="INSERT INTO fotos ";
		$stringq.=" VALUES(''
				,'".$nombre_foto."'
				,'".$_POST["descripcion"]."'
				,'".$_GET["id_relacion"]."'
				,'".$fila_tmp["nro"]."'
				,'".$_GET["nombre_abm"]."'
				)";
		mysql_query($stringq,$link);
		//echo $stringq;
		echo mysql_error($link);
	}
?>
    <div id="contenido">
      <table width="100%" border="0" cellspacing="100" cellpadding="0">
        <tr>
          <td align="center"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/please_wait.gif" alt="please wait" /></td>
        </tr>
      </table>
    </div>
    <script src="../includes/funciones_generales.js" type="text/javascript"></script>
    <script language="JavaScript">
	<!--
	  setTimeout('redireccionar("gallery_pop.php?id_relacion=<?=$_GET["id_relacion"]?>&nombre_abm=<?=$_GET["nombre_abm"]?>")', 1500);
	//-->
	</script>
