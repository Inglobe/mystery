<?php
	function existe_mail_mailbox($email,$id_newsletter){
		global $link;
		$fila_tmp = mysql_fetch_assoc(mysql_query("SELECT COUNT(*) AS nro FROM mailbox m, usuarios_news u WHERE m.id_usuario_news = u.id_usuario_news AND m.id_newsletter = ".$id_newsletter." AND u.email LIKE '".$email."' AND m.id_estado_envio = 1",$link));
		if($fila_tmp["nro"] == 0){
			return false;
		}
		else{
			return true;
		}
	}

	switch($_POST["opcion"]){
		case 1:
			mysql_query("UPDATE newsletters SET enviado = 1 WHERE id_newsletter = ".$_POST["id"],$link);
			if(is_array($_POST["grupos"])){
				foreach($_POST["grupos"] as $id_grupo){
			        $result = mysql_query("SELECT * FROM usuarios_news WHERE id_grupo_news = ".$id_grupo." AND activo = 1",$link);
			        while($fila = mysql_fetch_array($result)){
			        	if(!existe_mail_mailbox($fila["email"],$_POST["id"])){
			        		mysql_query("INSERT INTO mailbox VALUES('','".$fila["id_usuario_news"]."','".$_POST["id"]."','1',NOW(),'')",$link);
			        	}
			        }
				}
			}
		break;
		case 2:
			$result = mysql_query("SELECT * FROM newsletters WHERE id_newsletter = ".$_POST["id"],$link);
			$fila_newsletter = mysql_fetch_array($result);
			$html = $fila_newsletter["texto"];
			mail_html($_POST["email"],$fila_parametros["email_newsletter"],$fila_parametros["nombre_email_newsletter"],$fila_newsletter["email_reply"],$fila_newsletter["asunto"],$html,strip_tags($html));
		break;
	}
    $redireccionar="newsletters_enviar_feed";
?>
    <div id="contenido">
      <table width="100%" border="0" cellspacing="100" cellpadding="0">
        <tr>
          <td align="center"><img src="skins/<?=$abm_skin?>/<?=$idioma?>/please_wait.gif" alt="please wait"/></td>
        </tr>
      </table>
    </div>
    <script language="JavaScript">
	<!--
	  setTimeout('redireccionar("index.php?put=<?=$redireccionar?>&id=<?=$_POST["id"]?>")', 1500);
	//-->
	</script>