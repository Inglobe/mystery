<div id="titulo">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><h1>Enviar newsletter : </h1><?
		  $result = mysql_query("SELECT * FROM newsletters WHERE id_newsletter = ".$_GET["id"],$link);
	      $fila_newsletter=mysql_fetch_array($result);
	      echo $fila_newsletter["asunto"];
	 ?></td>
    </tr>
  </table>
</div>
<div id="contenido">
  <form id="form1" name="form1" method="post" action="index.php?put=newsletters_enviar_procesar">
  	<input type="hidden" name="id" value="<?=$_GET["id"]?>">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <?
		$result = mysql_query("SELECT * FROM grupos_news ORDER BY descripcion",$link);
		if(mysql_num_rows($result) > 0){
	  ?>
      <tr>
        <td height="30" align="left" valign="middle"><table border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><input name="opcion" type="radio" value="1" checked /></td>
              <td><strong>Grupos:</strong></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellpadding="0" cellspacing="0" class="recuadro">
            <tr>
              <td><table width="100%" border="0" cellspacing="5" cellpadding="0">
                  <tr>
                    <td>
					  <table width="100%" border="0" cellspacing="0" cellpadding="0">
		<?
            while($fila=mysql_fetch_array($result)){
		?>
						<tr>
                          <td width="25"><input type="checkbox" name="grupos[]" value="<?=$fila["id_grupo_news"]?>"></td>
                          <td><?=$fila["descripcion"]?> </td>
                        </tr>
		<?
			}
		?>
                      </table>
					</td>
                  </tr>
                </table></td>
            </tr>
          </table></td>
      </tr>
	  <?
	  	}
	  ?>
      <tr>
        <td height="30" valign="middle"><table border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td><input name="opcion" type="radio" value="2" /></td>
            <td><strong>E-mail de prueba:</strong></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="bottom" class="recuadro"><table width="100%" border="0" cellspacing="5" cellpadding="0">
          <tr>
            <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td width="50" align="center">e-mail:</td>
                  <td><input name="email" type="text" size="40" /></td>
                </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td height="30" valign="bottom"><table border="0" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td width="100" align="left"><a href="index.php?put=newsletters_enviados"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_cancelar.gif" alt="Pendientes" border="0" /></a></td>
              <td align="left"><input type="image" src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_enviar.gif" alt="Enviar" border="0" /></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
</div>
</form>