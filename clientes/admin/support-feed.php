<?php
	require_once("../../includes/conexion.inc.php");
	require_once("../../includes/funciones_generales.php");
	$result_consulta = mysql_query("SELECT * FROM parametros",$link);
	$fila_parametros=mysql_fetch_array($result_consulta);
	require_once("../../generar_form.inc.php");	
?>
<div id="page_tittle">
  <div id="ico"><img src="images/ico_soporte_tit-trans.png" width="47" height="50" alt="" /></div>
  <h1>Soporte</h1>
</div>
<div class="block">
<div id="form_feed">Su mensaje a sido enviado con &eacute;xito.<br /><br />
  <div class="button gradient_theme" style="margin-left:360px;"><a href="index.php?put=home">OK</a></div>
</div>
</div>
