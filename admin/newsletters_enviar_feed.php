<div id="titulo">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><h1>Enviar newsletter : <?
		  	$result = mysql_query("SELECT * FROM newsletters WHERE id_newsletter = ".$_GET["id"],$link);
			$fila_newsletter=mysql_fetch_array($result);
			echo $fila_newsletter["asunto"];
		  ?></h1></td>
    </tr>
  </table>
</div>
<div id="contenido">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="30" align="center" valign="bottom">El newsletter fue enviado con &eacute;xito</td>
      </tr>
      <tr>
        <td valign="bottom"><table border="0" align="center" cellpadding="0" cellspacing="7">
            <tr>
              <td align="left"><a href="index.php?put=newsletters_enviados"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_enviados.gif" alt="Enviados" border="0" /></a></td>
              <td align="left"><a href="index.php?put=newsletters_pendientes"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_pendientes.gif" alt="Pendientes" border="0" /></a></td>
              <td align="left"><a href="newsletters_ver.php?id=<?=$_GET["id"]?>" target="_blank"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_ver.gif" alt="Ver" border="0" /></a></td>
              <td align="left"><a href="index.php?put=newsletters_crear"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_nuevo.gif" alt="Nuevo" border="0" /></a></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</div>
