<?
		//Titulacion ABM
		$titulo_abm="Opciones";
		$sub_titulo_abm="Backup";
		$titulo_opcion="Descargar";
		include("includes/titulos.php");
?>
  <div id="contenido">
    <form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><table width="100%" border="0" align="center" cellpadding="0" cellspacing="3">
            <tr>
              <td align="center">Recuerde guardar su <strong>backup</strong> en un lugar seguro.</td>
            </tr>
            <tr>
              <td align="center"><a href="backup.php"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/btn_descargar.gif" alt="Descargar" border="0" /></a></td>
            </tr>
          </table></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
    </form>
  </div>

