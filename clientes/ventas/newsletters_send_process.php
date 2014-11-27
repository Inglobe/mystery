<?
	function existe_mail_mailbox($email,$id_newsletter){
		$db = new database;
		
		$sql = "SELECT 
					COUNT(*) AS nro 
				FROM 
					mailbox m
					JOIN suscribers s ON m.id_suscriber = s.id_suscriber
				WHERE 
					m.id_newsletter = ".$id_newsletter." AND 
					s.email LIKE '".$db->escape($email)."' AND 
					m.id_status = 1
				";
		$db->query($sql);
		$db->fetch();
		
		$nro = $db->getValue("nro");
		
		if($nro == 0) {
			return false;
		}
		else {
			return true;
		}
	}
	
	$db_upd = new database;
	
	$id = $data->get("id",DATA_EX_TYPE_INT);
	
	$db_upd->query("UPDATE newsletters SET sent = 1 WHERE id_newsletter = ".$id);
	
	if(is_array($_POST["groups"])){
		foreach($_POST["groups"] as $id_group){
			$db_insert = new database;
		
			$db_susc = new database;
			$sql = "SELECT id_suscriber, email FROM suscribers WHERE id_group = ".$db_susc->escape((int)$id_group)." AND enabled = 1";
			//echo $sql."<hr />";
			$db_susc->query($sql);
			while($db_susc->fetch()){
				if(!existe_mail_mailbox($db_susc->getValue("email"),$id)){
					$sql = "INSERT INTO 
								mailbox (
									id_suscriber,
									id_newsletter,
									id_status
								)
								VALUES (
									".$db_susc->getValue("id_suscriber").",
									".$id.",
									1
								)
							";
					//echo $sql."<hr />";
					$db_insert->query($sql);
				}
			}
		}
	}

    $redireccionar="index.php?put=newsletters_send_feed&id=".$id;
?>
<div id="please_wait"><img src="images/please_wait.gif" width="400" height="352" alt="" /></div>
<script language="javascript">
<!--
	setTimeout('redireccionar("<?=$redireccionar?>")', 1500);
//-->
</script>