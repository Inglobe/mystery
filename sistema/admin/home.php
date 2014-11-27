 <div id="titulo">
    <table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><h1>Bienvenidos</h1></td>
      </tr>
    </table>
  </div>
  <div id="contenido">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="100" align="center" valign="middle">Cargando...<br />
          <img src="imagenes/loadingAnimation.gif" alt="" width="208" height="13" style="padding-top:10px;" /></td>
        </tr>
      </table>
  </div>
<script language="JavaScript">
<!--
<?
if(!getUsrExterno($_SESSION["id_usr"])){
?>
setTimeout('redireccionar("index.php?put=agenda")', 1500);
<?
}
else {
?>
setTimeout('redireccionar("index.php?put=proyectos_search&cambiar=1")', 1500);
<?
}
?>
//-->
</script>
