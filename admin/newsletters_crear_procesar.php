<?
	$template = $_POST["template"];
	$asunto = $_POST["asunto"];
	$descripcion = $_POST["descripcion"];

	switch($_POST["tipo_accion"]){
		case "editar":
			ob_start();
			require("../newsletters/".$template."/newsletter.php");
			$buffer_html=ob_get_contents();
			ob_end_clean();
		break;
		case "importar":
			$ruta="tmp/".$_FILES["archivo_html"]["name"];
			move_uploaded_file($_FILES["archivo_html"]["tmp_name"],$ruta);
			$buffer_html = file_get_contents($ruta);
			unlink($ruta);
		break;
	}

	$buffer_html = str_replace("'","\\'",$buffer_html);
	$asunto = str_replace("'","\\'",$_POST["asunto"]);

	$stringq="INSERT INTO newsletters ";
	$stringq.="VALUES('','".$buffer_html."','".$asunto."','0','".convertirFechaParaMySQL($_POST["fecha"])."','".$_POST["email_from"]."','".$_POST["nombre_from"]."','".$_POST["email_reply"]."')";

	mysql_query($stringq,$link);
	echo mysql_error($link);
	$id_nuevo=mysql_insert_id($link);

    $redireccionar="newsletters_crear_feed";
?>
    <div id="contenido">
      <table width="100%" border="0" cellspacing="100" cellpadding="0">
        <tr>
          <td align="center"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/please_wait.gif" alt="please wait"/></td>
        </tr>
      </table>
    </div>
    <script language="JavaScript">
	<!--
	  setTimeout('redireccionar("index.php?put=<?=$redireccionar?>&feed=<?=$_POST["accion"]?>&id=<?=$id_nuevo?>")', 1500);
	//-->
	</script>