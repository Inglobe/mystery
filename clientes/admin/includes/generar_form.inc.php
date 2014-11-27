<?php
ob_end_flush();

$indice=0;
for($i=0;$i < sizeof($_POST); $i++){
	list($clave, $titulo) = each($_POST);

	$aux = explode("_",$clave);
	if($aux[0] == "campo"){
		$datos[$indice]["titulo"] = $titulo;

		list($clave, $campo) = each($_POST);
		$datos[$indice]["valor"] = $campo;

		$indice++;
	}
}

ob_start();
require("generar_form_mail.inc.php");
$html = ob_get_clean();
ob_end_flush();

ob_start();
require("generar_form_mail_usuario.inc.php");
$html_usuario = ob_get_clean();
ob_end_flush();

if(isset($_POST["email"])){
	if(!comprobar_email_duplicado($_POST["email"])){
		$stringq="INSERT INTO usuarios_news ";
		$stringq.="(fecha,nombre,telefono,email,id_grupo_news) ";
		$stringq.="VALUES(NOW(),'".$nombre."','".$telefono."','".$email."','".$fila_parametros["id_grupo_news_defecto"]."')";
		mysql_query($stringq,$link);
		echo mysql_error($link);
	}
}
if(comprobar_email($_POST["email"])){
	if(mail_html($fila_parametros["email_contactenos"],$fila_parametros["email_contactenos"],$fila_parametros["nombre_email_contactenos"],$_POST["email"],$_POST["email_asunto"],$html,strip_tags($html))){
		mail_html($_POST["email"],$fila_parametros["email_contactenos"],$fila_parametros["nombre_email_contactenos"],$fila_parametros["email_contactenos"],$_POST["email_usuario_asunto"]." ".$nombre,$html_usuario,strip_tags($html_usuario));
	}
}
?>