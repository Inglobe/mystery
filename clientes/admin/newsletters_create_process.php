<?
	$template = "default_template";
	$subject = $data->post("subject");
	$descripcion = $data->post("descripcion");

	switch($_POST["action"]){
		case "edit":
			ob_start();
			require("../newsletters/".$template."/newsletter.php");
			$buffer_html=ob_get_contents();
			ob_end_clean();
		break;
		case "import":
			$ruta="tmp/".$_FILES["archivo_html"]["name"];
			move_uploaded_file($_FILES["archivo_html"]["tmp_name"],$ruta);
			$buffer_html = file_get_contents($ruta);
			unlink($ruta);
		break;
	}

	$buffer_html = str_replace("'","\\'",$buffer_html);
	$subject = str_replace("'","\\'",$subject);
	
	$db_insert = new database;

	$sql="INSERT INTO 
				newsletters 
				VALUES(
					'',
					'".$db_insert->escape($buffer_html)."',
					'".$db_insert->escape($subject)."',
					'0',
					STR_TO_DATE('".$db_insert->escape($data->post("sent_date"))."','%d/%m/%Y'),
					'".$db_insert->escape($_POST["email_from"])."',
					'".$db_insert->escape($_POST["name_from"])."',
					'".$db_insert->escape($_POST["email_reply"])."'
				)";

	$db_insert->query($sql);
	
	$id_nuevo = $db_insert->getInsertId();

    $redireccionar="index.php?put=newsletters_create_feed&id=".$id_nuevo;
?>
<div id="please_wait"><img src="images/please_wait.gif" width="400" height="352" alt="" /></div>
<script language="javascript">
<!--
	setTimeout('redireccionar("<?=$redireccionar?>")', 1500);
//-->
</script>