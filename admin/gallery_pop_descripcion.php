<?
	require "procesos_globales.php";

	$fila_tmp=mysql_fetch_assoc(mysql_query("SELECT descripcion FROM fotos WHERE id_foto =".$_GET["id"],$link));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Galeria de Fotos</title>
<link href="skins/gris/estilos.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#scroll {
	height: 300px;
	overflow: auto;
}
-->
</style>
</head>
<body>
<div id="titulo">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><h1>Galer&iacute;a de Fotos</h1></td>
      <td class="separador_tit">/</td>
      <td><h1 class="gris">Editar</h1></td>
    </tr>
  </table>
</div>
<div id="contenido">
<form action="gallery_pop_descripcion_procesar.php?id=<?=$_GET["id"]?>&amp;id_relacion=<?=$_GET["id_relacion"]?>&amp;nombre_abm=<?=$_GET["nombre_abm"]?>" method="post">
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><table border="0" cellpadding="0" cellspacing="10" class="recuadro">
          <tr>
            <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <tr>
                  <td><textarea name="descripcion" cols="60" rows="5" id="campo_descripcion"><?=$fila_tmp["descripcion"]?></textarea></td>
                </tr>
                <tr>
                  <td height="30" align="right" valign="bottom"><table border="0" cellspacing="4" cellpadding="0">
                    <tr>
                      <td><a href="javascript:window.close()"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_cancelar.gif" alt="" width="93" height="19" border="0" /></a></td>
                      <td><input type="image" src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_ok.gif" alt="" width="92" height="19" /></td>
                    </tr>
                  </table></td>
                </tr>

              </table></td>
          </tr>
        </table></td>
    </tr>
  </table>
</form>
</div>
</body>
</html>
