<?
	require("procesos_globales.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Control Panel - ABM</title>
<link href="skins/gris/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
<table width="284" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><div id="titulo">
        <table border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><h1>Importar Contactos </h1></td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellpadding="5" cellspacing="0">
        <tr>
          <td class="recuadro"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="3">
            <tr>
              <td width="50%" align="right"><strong>Procesados:</strong></td>
              <td><?=$_GET["proc"]?></td>
            </tr>
            <tr>
              <td align="right"><strong>Insertados:</strong></td>
              <td><?=$_GET["ins"]?></td>
            </tr>
            <tr>
              <td align="right"><strong>Erroneos:</strong></td>
              <td><?=$_GET["err"]?></td>
            </tr>
            <tr>
              <td align="right"><strong>Duplicados:</strong></td>
              <td><?=$_GET["dup"]?></td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td align="right"><a href="#"><img src="skins/gris/es/btn_ok.gif" alt="" width="92" height="19" border="0" onclick="window.close()" /></a></td>
            </tr>
          </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
