<?php

require_once("procesos_globales.php");

$headers["User-Agent"] = "Mozilla/5.0 (Windows; U; Windows NT 5.1; es-AR; rv:1.8.1.7) Gecko/20070914 Firefox/2.0.0.7";

$auth["user"] = "dhmcontrol";
$auth["pass"] = "9L7SFSir6e";

$datos = httpRequest("www.zephia.com.ar:2083/accounts/addnew.php","POST",$_POST,$headers,null,$auth);
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
<div id="contenedor_loading_pop">
  <div id="loading_pop">Espere porfavor...<br />
    <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script type="text/javascript">
// <![CDATA[
  setTimeout('redireccionar("<?=$redireccionar?>?feed=<?=$_GET["accion"]?>&accion=<?=$_GET["accion"]?>&id=<?=$_GET["id"]?>")', 1500);
// ]]>
</script>
</body>
</html>
