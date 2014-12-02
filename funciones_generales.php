<?
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

function makeDatosByPost($post_vars,$files_vars){
	$i = 0;

	foreach($post_vars as $clave => $variable_post){
		$aux = explode("_",$clave);
		$tipo = array_shift($aux);
		$nombre_campo = implode("_",$aux);

		if($tipo == "texto" || $tipo == "combo" || $tipo == "check" || $tipo == "date" || $tipo == "pass"){
			$datos[$i]["nombre_campo"] = $nombre_campo;
			$datos[$i]["valor_campo"] = ($tipo=="date"?convertirFechaParaMySQL($variable_post):$variable_post);
			$datos[$i]["tipo_campo"] = $tipo;
			//echo "- ".$tipo."<br>";
			$i++;
		}

	}

	foreach($files_vars as $clave => $archivo_post){
		$aux = explode("_",$clave);
		$tipo = array_shift($aux);
		$nombre_campo = implode("_",$aux);

		$datos[$i]["nombre_campo"] = $nombre_campo;
		$datos[$i]["valor_campo"] = $archivo_post["name"];
		$datos[$i]["tipo_campo"] = $tipo;
		//echo "- ".$tipo."<br>";

		$i++;
	}

	return $datos;
}

function recortar_texto($texto,$nro_car){
	if($nro_car <= strlen($texto)){
		$salida=substr($texto,0,$nro_car);
		$salida=substr($salida,0,strrpos($salida," "))."...";
		return $salida;
	}
	else{
		return $texto;
	}
}

function mail_html($para,$remitente_email,$remitente_nombre,$reply_to,$asunto,$html,$texto,$log_mail=false){
	global $link;

    $basura = array("Content-Type:","MIME-Version:","Content-Transfer-Encoding:","Return-path:","Subject:","From:","Envelope-to:","To:",",","bcc:","cc:");
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

	$result_consulta = mysql_query("SELECT * FROM parametros",$link);
	$fila_parametros=mysql_fetch_array($result_consulta);
	$fila_parametros["metodo_envio"] = "smtp";
	$fila_parametros["host_smtp"] = "smtp.webfaction.com";
	$fila_parametros["usr_smtp"] = "mysteryweb";
	$fila_parametros["pass_smtp"] = "im2010na";

	//LOG MAIL
	if($log_mail){
		$mime_boundary = "----Message-Boundary----".md5(time());

		$headers="Return-path: <".$remitente_email.">".$salto;
		$headers.="Envelope-to: ".$para.$salto;
		$headers.="To: ".$para.$salto;
		$headers.="Subject: ".$asunto.$salto;
		$headers.="From: website@mail.mysterysur.com.ar".$salto;
		$headers.="Reply-To: ".$reply_to.$salto;
		$headers.="X-Mailer: PHP/".phpversion().$salto;
		$headers.="MIME-version: 1.0".$salto;
		$headers.="Content-type: multipart/alternative; boundary=\"".$mime_boundary."\"".$salto.$salto;
		$headers.="This is a multi-part message in MIME format.".$salto.$salto;
		$headers.="--".$mime_boundary.$salto;
		$headers.="Content-Type: text/plain; charset=iso-8859-1".$salto;
		$headers.="Content-Transfer-Encoding: 8bit".$salto.$salto;
		$headers.=$texto.$salto.$salto;
		$headers.="--".$mime_boundary.$salto;
		$headers.="Content-Type: text/html; charset=iso-8859-1".$salto;
		$headers.="Content-Transfer-Encoding: 8bit".$salto.$salto;
		$headers.=$html.$salto.$salto;
		$headers.="--".$mime_boundary."--".$salto.$salto;

		$fp = fopen("mail_".md5(time()).".eml","a+");
		fwrite($fp,$headers);
		fclose($fp);
	}

	//envio
	switch($fila_parametros["metodo_envio"]){
		case "smtp":
			require_once("phpmailer/class.phpmailer.php");

			$mail = new PHPMailer();
			$mail->SetLanguage("es", "./");

			$mail->IsSMTP();
			$mail->Host = $fila_parametros["host_smtp"];
			$mail->SMTPAuth = true;
			$mail->Username = $fila_parametros["usr_smtp"];
			$mail->Password = $fila_parametros["pass_smtp"];

			$mail->From = "website@mail.mysterysur.com.ar";
			$mail->FromName = $remitente_nombre;
			$mail->AddReplyTo($reply_to);
			$mail->AddAddress($para);

			$mail->Subject = $asunto;

			if($html!=""){
				$mail->IsHTML(true);
				$mail->Body = $html;
				$mail->AltBody = $texto;
			}
			else{
				$mail->Body = $texto;
			}

			if($mail->Send()){
				return true;
			}
			else{
				echo "> ".date("d/m/Y h:i:s",time())." - ".$para." - ".$mail->ErrorInfo."\n";
				/*$fp = fopen("smtp_errors.log","a+");
				fwrite($fp,;
				fclose($fp);
				return false;*/
			}
		break;

		case "php":
		default:
			$headers="From: website@mail.mysterysur.com.ar".$salto;
			$headers.="Reply-To: ".$reply_to.$salto;
			$headers.="X-Mailer: PHP/".phpversion().$salto;
			$headers.="MIME-version: 1.0".$salto;
			if($html!=""){
				$mime_boundary = "----Message-Boundary----".md5(time());
				$headers.="Content-type: multipart/alternative; boundary=\"".$mime_boundary."\"".$salto.$salto;
				$headers.="This is a multi-part message in MIME format.".$salto.$salto;
				$headers.="--".$mime_boundary.$salto;
				$headers.="Content-Type: text/plain; charset=iso-8859-1".$salto;
				$headers.="Content-Transfer-Encoding: 8bit".$salto.$salto;
				$headers.=$texto.$salto.$salto;
				$headers.="--".$mime_boundary.$salto;
				$headers.="Content-Type: text/html; charset=iso-8859-1".$salto;
				$headers.="Content-Transfer-Encoding: 8bit".$salto.$salto;
				$headers.=$html.$salto.$salto;
				$headers.="--".$mime_boundary."--".$salto.$salto;
				return mail($para,$asunto,"",$headers);
			}
			else{
				return mail($para,$asunto,$texto,$headers);
			}
		break;
	}
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

function ordenarRegistro($id,$id_nombre,$tabla,$campo_orden,$direccion,$consulta = ""){
	global $link;

	if($consulta == ""){
		$consulta = "SELECT ".$id_nombre.",".$campo_orden." FROM ".$tabla;
	}

	$consulta .= " ORDER BY ".$campo_orden." ASC";

	//echo $consulta."<br />";

	$result = mysql_query($consulta,$link);
	echo mysql_error($link);

	$nro_registros = mysql_num_rows($result);

	$cont = 0;
	while($fila_tmp=mysql_fetch_assoc($result)){
		$consulta = "UPDATE ".$tabla." SET ".$campo_orden." = ".($cont+1)." WHERE ".$id_nombre." = ".$fila_tmp[$id_nombre];
		//echo $consulta."<br />";
		mysql_query($consulta,$link);
		echo mysql_error($link);

		$mat_fotos[$cont]["id"] = $fila_tmp[$id_nombre];
		$mat_fotos[$cont]["orden"] = $fila_tmp[$campo_orden];
		$cont++;
	}

	for($i=0;$i<$nro_registros;$i++){
		if($mat_fotos[$i]["id"] == $id){
			$orden_campo_seleccionado = $mat_fotos[$i]["orden"];
			$id_campo_anterior = $mat_fotos[$i-1]["id"];
			$id_campo_posterior = $mat_fotos[$i+1]["id"];
		}
	}

	switch($direccion){
		case "up":
			if($orden_campo_seleccionado > 1){
				mysql_query("UPDATE ".$tabla." SET ".$campo_orden." = ".($orden_campo_seleccionado - 1)." WHERE ".$id_nombre." = ".$id,$link);
				echo mysql_error($link);

				mysql_query("UPDATE ".$tabla." SET ".$campo_orden." = ".($orden_campo_seleccionado)." WHERE ".$id_nombre." = ".$id_campo_anterior,$link);
				echo mysql_error($link);
			}
		break;
		case "down":
			if($orden_campo_seleccionado < $nro_registros){
				mysql_query("UPDATE ".$tabla." SET ".$campo_orden." = ".($orden_campo_seleccionado + 1)." WHERE ".$id_nombre." = ".$id,$link);
				echo mysql_error($link);

				mysql_query("UPDATE ".$tabla." SET ".$campo_orden." = ".($orden_campo_seleccionado)." WHERE ".$id_nombre." = ".$id_campo_posterior,$link);
				echo mysql_error($link);
			}
		break;
	}
}
function comprobarUsuario($usuario){
	global $link;
	
	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM usuarios WHERE user LIKE '".$usuario."'",$link));
	echo mysql_error($link);
	
	if($fila_tmp["nro"] > 0){
		return false;
	}
	else {
		return true;
	}
}

function getFoto($id,$abm=null){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT foto FROM fotos WHERE id_relacion = ".$id." ".($abm!=null?"AND abm LIKE '".$abm."'":"")." ORDER BY orden ASC LIMIT 1",$link));
	echo mysql_error($link);

	return $fila_tmp["foto"];
}
function getDescFoto($id,$abm=null){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT descripcion FROM fotos WHERE id_relacion = ".$id." ".($abm!=null?"AND abm LIKE '".$abm."'":"")." ORDER BY orden ASC LIMIT 1",$link));
	echo mysql_error($link);

	return $fila_tmp["descripcion"];
}
function getIdFoto($id,$abm=null){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT id_foto FROM fotos WHERE id_relacion = ".$id." ".($abm!=null?"AND abm LIKE '".$abm."'":"")." ORDER BY orden ASC LIMIT 1",$link));
	echo mysql_error($link);

	return $fila_tmp["id_foto"];
}
//**************************   SEO   ********************************
function make_url_friendly($url){
  $url = strtolower($url);
  $find = array(' ',
                '&',
                '\r\n',
                '\n',
                '+');
  $url = str_replace ($find, '-', $url);
  $find = array('/[^a-z0-9\-<>]/',
                '/[\-]+/',
                '/<[^>]*>/');
  $repl = array('',
                '-',
                '');
  $url =  preg_replace ($find, $repl, $url);
  return $url;
}

function getTitNoticia($id_novedad){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT titulo FROM news WHERE id_new = ".$id_novedad,$link));
	echo mysql_error($link);
	return make_url_friendly($fila_tmp["titulo"]);
}

function getFechaNoticia($id_novedad){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT DATE_FORMAT(fecha,'%Y/%m/%d/') AS fecha_f FROM news WHERE id_new = ".$id_novedad,$link));
	echo mysql_error($link);
	return $fila_tmp["fecha_f"];
}

function getTitEmprendimiento($id_emprendimiento){
	global $link;

	$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT nombre FROM emprendimientos WHERE id_emprendimiento = ".$id_emprendimiento,$link));
	echo mysql_error($link);
	return make_url_friendly($fila_tmp["nombre"]);
}

function getRuta(){
	global $url_site;

	return $url_site."/";
}

function reescribir_links($contenido){

	//paginacion novedades
	$patron[] = '/(?<!\/)index.php\?put=novedades&amp;ls=([0-9]*)/e';
    $reemplazo[] = "'/' . 'novedades-ls$1.html'";

    //novedades ampliada
	$patron[] = '/(?<!\/)index.php\?put=novedades-ampliada&amp;id_novedad=([0-9]*)/e';
    $reemplazo[] = "'/noticias/' . getFechaNoticia('$1') . '$1/' . getTitNoticia('$1') . '.html'";

    //paginacion emprendimientos
	$patron[] = '/(?<!\/)index.php\?put=emprendimientos&amp;ls=([0-9]*)/e';
    $reemplazo[] = "'/' . 'emprendimientos-ls$1.html'";

    //emprendimientos ampliado
	$patron[] = '/(?<!\/)index.php\?put=emprendimientos-ampliado&amp;id_emprendimiento=([0-9]*)/e';
    $reemplazo[] = "'/emprendimientos/$1/' . getTitEmprendimiento('$1') . '.html'";

	//general (put)
    $patron[] = '/(?<!\/)index.php\?put=([a-zA-Z0-9\-]*)/e';
    $reemplazo[] = "'/' . '$1' . '.html'";

    /*$patron[] = '/(?<!\/)src="/e';
    $reemplazo[] = "'src=\"' . getRuta()";

    $patron[] = '/(?<!\/)link\040href="/e';
    $reemplazo[] = "'link href=\"' . getRuta()";

    $patron[] = '/(?<!\/)"src",\040"/e';
    $reemplazo[] = "'\"src\", \"' . getRuta()";

    $patron[] = '/(?<!\/)sFlashSrc:"/e';
    $reemplazo[] = "'sFlashSrc:\"' . getRuta()";*/

    $contenido = preg_replace($patron, $reemplazo, $contenido);
    return $contenido;
}
//***************************************************************
function xmlcharacters($string, $trans='') {
	$trans=(is_array($trans))? $trans:get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
	foreach ($trans as $k=>$v)
		$trans[$k]= "&#".ord($k).";";
	return strtr($string, $trans);
}
function xhtmlOut($entrada){
	return nl2br(xmlcharacters($entrada));
}
?>