<?
if(comprobar_email($_POST["email"])){
	if(!comprobar_email_duplicado($_POST["email"])){
		$consulta = "INSERT INTO usuarios_news (fecha, nombre, email, telefono, id_grupo_news, activo) VALUES (NOW(),'".$_POST["nombre"]."','".$_POST["email"]."','".$_POST["telefono"]."','2','1')";
		mysql_query($consulta,$link);
		echo mysql_error($link);
		
		ob_start();
		require("suscripcion_mail.inc.php");
		$html_usuario = ob_get_clean();
		ob_end_flush();

		mail_html($_POST["email"],"website@mysterysur.com.ar","Mystery Sur",$fila_parametros["email_contactenos"],"Gracias por subscribirse",$html_usuario,strip_tags($html_usuario));
		
		$txt_feed = "Su suscripci&oacute;n fue realizada con &eacute;xito.";
	}
	else{
		$txt_feed = "Usted ya est&aacute; suscripto a nuestro newsletter.";
	}
}
else{
	$txt_feed = "Por favor verifique que su direccion&oacute;n de correo est&eacute; escrita correctamente.";
}
?>

<div id="header_seccion"> <img src="imagenes/img_header_contacto.png" width="182" height="157" alt="" style="padding-top:60px; padding-left:70px;" />
  <h1><span>Suscripci&oacute;n al Newsletter</span></h1>
</div>
<div id="fondo_secciones">
  <div id="col_izq_seccion">
    <?php include("datos_contacto.inc.php"); ?>
  </div>
  <div id="col_der_seccion">
    <div id="form_contacto">
      <div style="padding-top:100px; padding-bottom:100px; text-align:center;">
        <p><?= $txt_feed ?></p>
        <div><a href="index.php?put=home"><img src="imagenes/btn_ok.png" style="padding-top:10px;" alt="" /></a></div>
      </div>
    </div>
  </div>
</div>
