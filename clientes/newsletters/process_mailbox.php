<?php
require_once('../includes/config.php');
require_once('../includes/paths.php');

require_once(PATH_ADMIN_PROCESOS_GLOBALES);

$db = new database;
$sql = "SELECT 		
			m.*,
			s.*,
			n.content,
			n.subject,
			n.email_reply,
			n.email_from,
			n.name_from
		FROM 		
			mailbox m
			JOIN newsletters n ON m.id_newsletter = n.id_newsletter
			JOIN suscribers s ON m.id_suscriber = s.id_suscriber
		WHERE   
			m.id_status = 1 AND
			n.sent_date <= now()
		ORDER BY 
			m.creation_date DESC
		LIMIT ".$db->escape($parametros->nro_envios_lote)."
		";
$db->query($sql);

$cont=0;
$cont_enviados=0;
$cont_error=0;

while($db->fetch()){
	$cont++;

	$buscar = 	  array(	"[ID_SUSCRIBER]",
							"[ID_NEWSLETTER]",
							"[EMAIL]",
							"[NAME]",
							"[TRACK]",
							"[URL_REMOVE]",
							"[CUSTOM_0]",
							"[CUSTOM_1]",
							"[CUSTOM_2]",
							"[CUSTOM_3]",
							"[CUSTOM_4]",
							"[CUSTOM_5]",
							"[CUSTOM_6]",
							"[CUSTOM_7]",
							"[CUSTOM_8]",
							"[CUSTOM_9]"
						);
	$reemplazar = array(	$db->getValue("id_suscriber"),
							$db->getValue("id_newsletter"),
							$db->getValue("email"),
							$db->getValue("name"),
							"<img src=\"".URL."/newsletters/track.php?idn=".$db->getValue("id_newsletter")."&ids=".$db->getValue("id_suscriber")."\" width=\"1\" height=\"1\" border=\"0\" />",
							URL."/newsletters/remover.php?email=".$db->getValue("email")."&ids=".$db->getValue("id_suscriber"),
							$db->getValue("custom_0"),
							$db->getValue("custom_1"),
							$db->getValue("custom_2"),
							$db->getValue("custom_3"),
							$db->getValue("custom_4"),
							$db->getValue("custom_5"),
							$db->getValue("custom_6"),
							$db->getValue("custom_7"),
							$db->getValue("custom_8"),
							$db->getValue("custom_9")
						);

	$html = str_replace($buscar,$reemplazar,$db->getValue("content"));

	$asunto = str_replace($buscar,$reemplazar,$db->getValue("subject"));

	if(mail_html($db->getValue("email"),$db->getValue("email_from"),$db->getValue("nombre_from"),$db->getValue("email_reply"),$asunto,$html,strip_tags($html))){
		$cont_enviados++;
		$db_upd = new database;
		$db_upd->query("UPDATE mailbox SET id_status = 2, sent_date = NOW() WHERE id_mailbox = ".$db->getValue("id_mailbox"));
	}
	else{
		$cont_error++;
		$db_upd = new database;
		$db_upd->query("UPDATE mailbox SET id_status = 3, sent_date = NOW() WHERE id_mailbox = ".$db->getValue("id_mailbox"));
	}
}

if($cont > 0){
	$fp = fopen("sent.log","a+");
	$log_text = "> ".$cont_enviados." enviados\t".date("d/m/Y H:i:s",time())."\r\n";
	fwrite($fp,$log_text);
	fclose($fp);
}
?>