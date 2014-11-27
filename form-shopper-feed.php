<?php
	
	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT nombre FROM provincias WHERE id = ".(int)$_POST["pid"],$link));
	$_POST["pid"] = $fila_tmp["nombre"];
	
	require_once("generar_form_shopper.inc.php");
	include_once("makeCSV.php");
	makeCSV($_POST,"registros_shoppers.csv");
	
	//print_r($_POST);
?>
<div id="header_seccion"> <img src="imagenes/img_header_contacto.png" width="182" height="157" alt="" style="padding-top:60px; padding-left:70px;" />
  <h1 style="font-size:40px; padding-top:20px;"><span>Quer&eacute;s ser un <strong>Mystery Shopper</strong>?</span></h1>
</div>
<div id="fondo_secciones">
<div style="padding-top:100px; padding-bottom:100px; text-align:center;">
        <p>Gracias por dejarnos tus datos.    </p>
        <div><a href="index.php?put=home"><img src="imagenes/btn_ok.png" style="padding-top:10px;" alt="" /></a></div>
  </div>
</div>
