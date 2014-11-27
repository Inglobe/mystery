<?
	require("procesos_globales.php");
	
	enviarMailTicket($_GET["id"]);
?>
<div id="contenedor_loading" style="margin-top: 70px; margin-left: 40px;">
  <div id="loading" style="font-family: Arial; color: #666666; font-size: 11px;">Enviando... espere por favor.<br />
  <img src="imagenes/loadingAnimation.gif" alt="please wait" vspace="4" /></div>
</div>
<script language="JavaScript">
<!--
  setTimeout('window.close()', 1500);
//-->
</script>