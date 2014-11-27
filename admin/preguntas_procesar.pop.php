<?
	require_once("procesos_globales.php");

	switch($_GET["accion"]){
		case "d":
			mysql_query("DELETE FROM preguntas WHERE id_pregunta = ".$_GET["id_eliminar"],$link);
			$redireccionar="preguntas_search.pop.php?id=".$_GET["id"];
		break;
		case "a":
			$stringq="
				INSERT INTO preguntas (
					id_encuesta,
					descripcion_es,
					votos
				) VALUES (
					'".$_GET["id"]."',
					'".$_POST["descripcion_es"]."',
					0
				)
			";
			mysql_query($stringq,$link);
			echo mysql_error($link);
			$redireccionar="preguntas_search.pop.php?id=".$_GET["id"];
		break;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding: 10px;
}
-->
</style>
<link href="clases/ABMControls/datePicker/styles/fsdateselect.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Sistema de administraci&oacute;n</title>
<link href="css_library/estilos.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js_library/funciones.js"></script>
</head>
<body>
<div id="contenido">
      <table width="100%" border="0" cellspacing="100" cellpadding="0">
        <tr>
          <td align="center"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/please_wait.gif" alt="please wait" /></td>
        </tr>
      </table>
    </div>
<script type="text/javascript">
// <![CDATA[
  setTimeout('redireccionar("<?=$redireccionar?>?feed=<?=$_GET["accion"]?>&accion=<?=$_GET["accion"]?>&id=<?=$_GET["id"]?>")', 1500);
// ]]>
</script>
</body>
</html>
