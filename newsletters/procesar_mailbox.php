<?php
require("../includes/conexion.inc.php");
require("../includes/funciones_generales.php");

$result_consulta = mysql_query("SELECT * FROM parametros",$link);
$fila_parametros=mysql_fetch_array($result_consulta);

$consulta = "SELECT 		m.*,
							un.email,
							un.nombre,
							n.texto,
							n.asunto,
							n.email_reply,
							n.email_from,
							n.nombre_from
				FROM 		mailbox m,
							newsletters n,
							usuarios_news un
				WHERE 		un.id_usuario_news = m.id_usuario_news
				AND 		m.id_newsletter = n.id_newsletter
				AND 		m.id_estado_envio = 1
				AND 		n.fecha <= now()
				ORDER BY 	m.fecha_creacion desc
				LIMIT 		".$fila_parametros["nro_envios_lote"]."
				";

$cont=0;
$cont_enviados=0;
$cont_error=0;
$result = mysql_query($consulta,$link);
echo mysql_error($link);
while($fila=mysql_fetch_array($result)){
	$cont++;

	$buscar = 	  array(	"[ID_USUARIO_NEWS]",
							"[ID_NEWSLETTER]",
							"[EMAIL]",
							"[NOMBRE]",
							"[TRACK]",
							"[URL_REMOVER]"
						);
	$reemplazar = array(	$fila["id_usuario_news"],
							$fila["id_newsletter"],
							$fila["email"],
							$fila["nombre"],
							"<img src=\"".$url_site."/newsletters/track.php?id_newsletter=".$fila["id_newsletter"]."&id_usuario_news=".$fila["id_usuario_news"]."\" width=\"1\" height=\"1\" border=\"0\" />",
							$url_site."/newsletters/remover.php?email=".$fila["email"]."&id_usuario_news=".$fila["id_usuario_news"]
						);

	$html = str_replace($buscar,$reemplazar,$fila["texto"]);

	$asunto = str_replace($buscar,$reemplazar,$fila["asunto"]);

	if(mail_html($fila["email"],$fila["email_from"],$fila["nombre_from"],$fila["email_reply"],$asunto,$html,strip_tags($html))){
		$cont_enviados++;
		mysql_query("UPDATE mailbox SET id_estado_envio = 2, fecha_envio = NOW() WHERE id_mailbox = ".$fila["id_mailbox"],$link);
		echo mysql_error($link);
	}
	else{
		$cont_error++;
		mysql_query("UPDATE mailbox SET id_estado_envio = 3, fecha_envio = NOW() WHERE id_mailbox = ".$fila["id_mailbox"],$link);
		echo mysql_error($link);
	}
}

if($cont > 0){
	$fp = fopen("sent.log","a+");
	$log_text = "> ".$cont_enviados." enviados\t".date("d/m/Y H:i:s",time())."\r\n";
	fwrite($fp,$log_text);
	fclose($fp);
}
?>