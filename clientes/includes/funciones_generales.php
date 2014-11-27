<?
	function convertirFechaDesdeMySQL($fecha_mysql){

		$aux = explode("-",$fecha_mysql);
		$fecha = $aux[2]."/".$aux[1]."/".$aux[0];

		return($fecha);
	}
	
	function convertirFechaParaMySQL($fecha_mysql){

		$aux = explode("/",$fecha_mysql);
		$fecha = $aux[2]."-".$aux[1]."-".$aux[0];

		return($fecha);
	}
	
	function getExtension($archivo){

		$aux = explode(".",$archivo);
		foreach($aux as $tipo){
			$extencion = $tipo;
		}
		$extencion = strtolower($extencion);

		return($extencion);
	}
	
	if (!function_exists("str_split")) {
		function str_split($str,$length = 1) {
		
			if ($length < 1) return false;
			
			$strlen = strlen($str);
			$ret = array();
			for ($i = 0; $i < $strlen; $i += $length) {
				$ret[] = substr($str,$i,$length);
			}
			
			return $ret;
		}
	}
	
	function mail_html($para,$remitente_email,$remitente_nombre,$reply_to,$asunto,$html,$texto,$log_mail=false){
	
		$params = new parametros;
	
		$basura = array("Content-Type:","MIME-Version:","Content-Transfer-Encoding:","Return-path:","Subject:","From:","Envelope-to:","To:","bcc:","cc:");
		
		foreach($basura as $valor){
		
			if(strpos(strtolower($para), strtolower($valor)) !== false){
				return false;
			}
			
			if(strpos(strtolower($reply_to), strtolower($valor)) !== false){
				return false;
			}
			
			if(strpos(strtolower($remitente_email), strtolower($valor)) !== false){
				return false;
			}
			
			if(strpos(strtolower($asunto), strtolower($valor)) !== false){
				return false;
			}
		}
		
		$salto = "\n";
	
		//LOG MAIL
		if($log_mail){
		
			$mime_boundary = "----Message-Boundary----".md5(time());
	
			$headers = "";
			$headers .= "Return-path: <".$remitente_email.">".$salto;
			$headers .= "Envelope-to: ".$para.$salto;
			$headers .= "To: ".$para.$salto;
			$headers .= "Subject: ".$asunto.$salto;
			$headers .= "From: ".$remitente_nombre." <".$remitente_email.">".$salto;
			$headers .= "Reply-To: ".$reply_to.$salto;
			$headers .= "X-Mailer: PHP/".phpversion().$salto;
			$headers .= "MIME-version: 1.0".$salto;
			$headers .= "Content-type: multipart/alternative; boundary=\"".$mime_boundary."\"".$salto.$salto;
			$headers .= "This is a multi-part message in MIME format.".$salto.$salto;
			$headers .= "--".$mime_boundary.$salto;
			$headers .= "Content-Type: text/plain; charset=iso-8859-1".$salto;
			$headers .= "Content-Transfer-Encoding: 8bit".$salto.$salto;
			$headers .= $texto.$salto.$salto;
			$headers .= "--".$mime_boundary.$salto;
			$headers .= "Content-Type: text/html; charset=iso-8859-1".$salto;
			$headers .= "Content-Transfer-Encoding: 8bit".$salto.$salto;
			$headers .= $html.$salto.$salto;
			$headers .= "--".$mime_boundary."--".$salto.$salto;
	
			$fp = fopen("mail_".md5(time()).".eml","a+");
			fwrite($fp,$headers);
			fclose($fp);
		}		
	
		//envio
		switch($params->metodo_envio){
		
			case "smtp":
			
				require_once("phpmailer/class.phpmailer.php");
	
				$mail = new PHPMailer();
				//$mail->SetLanguage("es", "./");
				
				//$mail->SMTPDebug = true;
	
				$mail->IsSMTP();
				$mail->SMTPAuth = true;
				$mail->SMTPSecure = 'ssl'; 	
				$mail->Host = $params->host_smtp;
				$mail->Port = 465; 
				
				$mail->Username = $params->usr_smtp;
				$mail->Password = $params->pass_smtp;
	
				$mail->From = $remitente_email;
				$mail->FromName = $remitente_nombre;
				$mail->AddReplyTo($reply_to);
				$mail->AddAddress($para);
	
				$mail->Subject = $asunto;
	
				if($html!=""){
					$mail->IsHTML(true);
					$mail->Body = $html;
					$mail->AltBody = $texto;
				}else{
					$mail->Body = $texto;
				}
	
				if($mail->Send()){
					return true;
				}else{
					$fp = fopen("smtp_errors.log","a+");
					fwrite($fp,"> ".date("d/m/Y h:i:s",time())." - ".$para." - ".$mail->ErrorInfo)."\n";
					fclose($fp);
					return false;
				}
				
				break;
	
			case "php":
				break;
				
			default:
			
				$headers = "";
				$headers .= "From: ".$remitente_nombre." <".$remitente_email.">".$salto;
				$headers .= "Reply-To: ".$reply_to.$salto;
				$headers .= "X-Mailer: PHP/".phpversion().$salto;
				$headers .= "MIME-version: 1.0".$salto;
				
				if($html != ""){
				
					$mime_boundary = "----Message-Boundary----".md5(time());
					$headers .= "Content-type: multipart/alternative; boundary=\"".$mime_boundary."\"".$salto.$salto;
					$headers .= "This is a multi-part message in MIME format.".$salto.$salto;
					$headers .= "--".$mime_boundary.$salto;
					$headers .= "Content-Type: text/plain; charset=iso-8859-1".$salto;
					$headers .= "Content-Transfer-Encoding: 8bit".$salto.$salto;
					$headers .= $texto.$salto.$salto;
					$headers .= "--".$mime_boundary.$salto;
					$headers .= "Content-Type: text/html; charset=iso-8859-1".$salto;
					$headers .= "Content-Transfer-Encoding: 8bit".$salto.$salto;
					$headers .= $html.$salto.$salto;
					$headers .= "--".$mime_boundary."--".$salto.$salto;
					
					return mail($para,$asunto,"",$headers);
					
				}else{
					return mail($para,$asunto,$texto,$headers);
				}
				
				break;
		}
	}
	
	function getFoto($id,$abm=null){
		
		$db = new database;
	
		$db->query("SELECT foto FROM fotos WHERE id_relacion = ".$id." ".($abm != null ? " AND abm LIKE '".$abm."'" : "")." ORDER BY orden ASC LIMIT 1");
		$db->fetch();
	
		return $db->getValue("foto");
	}
	
	function getIdFoto($id,$abm=null){
	
		$db = new database;
	
		$db->query("SELECT id_foto FROM fotos WHERE id_relacion = ".$id." ".($abm!=null?"AND abm LIKE '".$abm."'":"")." ORDER BY orden ASC LIMIT 1");
		$db->fetch();
	
		return $db->getValue("id_foto");
	}
	
	function xmlcharacters($string, $trans=''){
	
		$trans = is_array($trans) ? $trans : get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
		
		foreach ($trans as $k => $v){
			$trans[$k]= "&#".ord($k).";";
		}
		
		return strtr($string, $trans);
	}
	
	function xhtmlOut($entrada){
		return nl2br(xmlcharacters($entrada));
	}
	function comprobar_email($email){
    $mail_correcto = 0;
    //compruebo unas cosas primeras
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter.
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminación del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
}
	function comprobar_email_duplicado($email,$id_grupo_news = 0){
	global $link;
	$cadena="SELECT 	COUNT(*) AS NRO
				FROM 	usuarios_news
				WHERE 	email LIKE '".$email."'
	";
	if($id_grupo_news!=0){
		$cadena.="AND id_grupo_news = ".$id_grupo_news;
	}
	$fila_tmp=mysql_fetch_array(mysql_query($cadena,$link));
	echo mysql_error($link);
	if($fila_tmp["NRO"]==0)
		return false;
	else
		return true;
}
?>