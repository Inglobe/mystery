<?
	require("../includes/conexion.inc.php");

	$consulta = "UPDATE usuarios_news SET activo = 0 WHERE id_usuario_news = ".$id_usuario_news." AND email LIKE '".$email."'";
	mysql_query($consulta,$link);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Desuscripci&oacute;n del Newsletters</title>
<style type="text/css">
<!--
.recuadro {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	background-color: #F9F9F9;
	border: 1px solid #999999;
}
-->
</style>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="80" align="center" valign="middle"><img src="../imagenes/logo.png" alt="" width="227" /></td>
  </tr>
  <tr>
    <td><table border="0" align="center" cellpadding="0" cellspacing="0" class="recuadro">
      <tr>
        <td width="300" height="80" align="center"><table border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td width="30" align="left"><img src="ico_remover.gif" alt="" width="19" height="23" /></td>
            <td>Ud. se ha eliminado de la base de datos con &eacute;xito.</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
