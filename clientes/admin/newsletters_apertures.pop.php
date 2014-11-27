<?
require_once('../includes/config.php');
require_once('../includes/paths.php');

require_once(PATH_ADMIN_PROCESOS_GLOBALES);

$id = $data->get("id",DATA_EX_TYPE_INT);

$db_news = new database_format;
$sql = "SELECT 
			subject, 
			name_from, 
			email_from, 
			email_reply, 
			DATE_FORMAT(sent_date,'%d/%m/%Y') AS sent_date_f 
		FROM 
			newsletters 
		WHERE 
			id_newsletter = ".$id;
$db_news->query($sql);
$db_news->fetch();

$db_list = new database_format;
$sql="SELECT 		
			s.name,
			s.email,
			DATE_FORMAT(t.track_date,'%d/%m/%Y %H:%i:%S') AS track_date_f,
			t.ip	
		FROM
			suscribers s
			JOIN tracking t ON t.id_suscriber = s.id_suscriber
		WHERE
			t.id_newsletter = ".$id." 
		ORDER BY 
			s.email ASC
	";
$db_list->query($sql);

$nro_ap = $db_list->getRows();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Aperturas:
<?=$db_news->getXHTMLValue("subject")?>
</title>
<style type="text/css">
<!--
body {
	background-color: #FFFFFF;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #666666;
	margin: 0px;
	padding-top: 10px;
	padding-right: 10px;
	padding-bottom: 0px;
	padding-left: 10px;
}
-->
</style>
<link href="css_library/styles.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div class="button gradient_theme"><a href="newsletters_export_suscribers_track_save.php?id=<?=$id?>">Descargar reporte</a></div>
<div id="aperture_numbers">N&uacute;mero de aperturas: <strong>
  <?=$nro_ap?>
  </strong></div>
<div class="block">
  <table width="100%" cellspacing="0" cellpadding="0" border="0" id="tabla_search">
    <thead>
      <tr>
        <th width="180" align="left"> E-mail </th>
        <th align="left">Nombre</th>
        <th width="40" align="left">Hora</th>
        <th width="80" align="left"> IP </th>
      </tr>
    </thead>
    <tbody>
      <?
			$color = "light_row";
			$num=0;
			while($db_list->fetch()){
				$num++;
				$color = ($color=="light_row"?"dark_row":"light_row")
			?>
      <tr class="<?=$color?>">
        <td align="left"><?=$db_list->getXHTMLValue("email")?></td>
        <td align="left"><?=$db_list->getXHTMLValue("name")?></td>
        <td align="left"><?=$db_list->getXHTMLValue("track_date_f")?></td>
        <td align="left"><a href="http://network-tools.com/default.asp?host=<?=$db_list->getValue("getValue")?>">
          <?=$db_list->getValue("getValue")?>
          </a></td>
      </tr>
      <?
			}
			if($num==0){
			?>
      <tr>
        <td colspan="5" align="center">No se encontraron registros.</td>
      </tr>
      <?
			}
			?>
    </tbody>
  </table>
</div>
</body>
</html>
