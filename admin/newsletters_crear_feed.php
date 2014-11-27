<div id="titulo">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><h1>Creaci&oacute;n de newsletter </h1></td>
    </tr>
  </table>
</div>
<div id="contenido">
  <form id="form1" name="form1" method="post" action="">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" align="center" valign="bottom">El newsletter se cre&oacute; correctamente!..</td>
      </tr>
      <tr>
        <td valign="bottom"><table border="0" align="center" cellpadding="0" cellspacing="7">
            <tr>
              <td align="left"><a href="index.php?put=newsletters_pendientes"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_pendientes.gif" alt="Pendientes" border="0" /></a></td>
              <td align="left"><a href="newsletters_ver.php?id=<?=$_GET["id"]?>" target="_blank"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_ver.gif" alt="Ver" border="0" /></a></td>
              <td align="left"><a href="index.php?put=newsletters_enviar&id=<?=$_GET["id"]?>"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_enviar.gif" alt="Enviar" border="0" /></a></td>
              <td align="left"><a href="newsletters_save.php?id=<?=$_GET["id"]?>" target="_blank"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_descargar_html.gif" alt="Descargar HTML" border="0" /></a></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
  </form>
</div>
