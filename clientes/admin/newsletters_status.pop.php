<?
require_once('../includes/config.php');
require_once('../includes/paths.php');

require_once(PATH_ADMIN_PROCESOS_GLOBALES);

$id = $data->get("id",DATA_EX_TYPE_INT);

function check_apertura($id_newsletter, $id_suscriber) {
	
	$db = new database;
	$sql = "SELECT COUNT(*) AS nro FROM tracking WHERE id_newsletter = ".$id_newsletter." AND id_suscriber = ".$id_suscriber;
	$db->query($sql);
	$db->fetch();
    $nro = $db->getValue("nro");
    if($nro == 0)
        return false;
    else
        return true;
}

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
$sql = "SELECT	 	
				s.name,
				m.id_newsletter,
				m.id_suscriber,
				s.email,
				DATE_FORMAT(m.creation_date,'%d/%m/%Y %H:%i:%S') AS creation_date_f,
				DATE_FORMAT(m.sent_date,'%d/%m/%Y %H:%i:%S') AS sent_date_f,
				m.id_status,
				ee.description AS status_desc
			FROM
				suscribers s
				JOIN mailbox m ON m.id_suscriber = s.id_suscriber
				JOIN status ee ON ee.id_status = m.id_status
			WHERE 
				m.id_newsletter = ".$id;

if(isset($_GET["filtro"]) && $_GET["filtro"] != 0) {
    $sql .= " AND m.id_status = ".$_GET["filtro"];
}

$sql.=" ORDER BY s.email ASC";

$db_list->query($sql);

if(isset($_GET["filtro"]) && $_GET["filtro"] != 0){
	$nro_encontrados = $db_list->getRows();
}

$db_nro = new database;
$db_nro->query("SELECT COUNT(*) AS nro FROM mailbox WHERE id_newsletter = ".$id);
$db_nro->fetch();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Estado de env&iacute;o: <?=$db_news->getXHTMLValue("subject")?></title>
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
<div id="sending_data"><strong>Fecha de env&iacute;o:</strong> <?=$db_news->getXHTMLValue("sent_date_f")?><br />
  <strong>De:</strong> <?=$db_news->getXHTMLValue("name_from")?> &lt;<?=$db_news->getXHTMLValue("email_from")?>&gt;<br />
<strong>Responder a:</strong> <?=$db_news->getXHTMLValue("email_reply")?></div>
<div id="cont_btns_ok_cancel" style="height:50px;">
<div id="btns_ok_cancel">
  <div class="button gradient_theme"><a href="newsletters_status.pop.php?id=<?=$id?>&error_pendientes=1" onclick="return confirm('Esta operación pasará los envios con error a pendientes.\nDesea continuar?')">Erroneos a pendientes</a></div>
</div>
</div>
<div id="sents_numbers">N&uacute;mero de envios: <strong><?=$db_nro->getValue("nro")?></strong></div>
<div id="filter_status">
  <form id="form_filtro" name="form_filtro" method="get" action="newsletters_status.pop.php">
	<input type="hidden" name="id" value="<?=$id?>" />
    <label for="select"><strong>Mostar:</strong></label>
    <select name="filtro" onchange="document.form_filtro.submit();">
	  <option value="todos" <?=($_GET["filtro"] == "todos")?"selected":""?>>--todos--</option>
	  <option value="1" <?=($_GET["filtro"] == 1)?"selected":""?>>Pendientes</option>
	  <option value="2" <?=($_GET["filtro"] == 2)?"selected":""?>>Enviados</option>
	  <option value="3" <?=($_GET["filtro"] == 3)?"selected":""?>>Error</option>
    </select>
  </form>
</div>
<div id="list">
  <div class="block_top_list">
    <div class="cont_bg_block_top_left">
      <div class="bg_block_top_left_list"><span></span></div>
    </div>
    <div class="cont_bg_block_top_right">
      <div class="bg_block_top_right_list"><span></span></div>
    </div>
  </div>
  <div class="border_block_left">
    <div class="border_block_right">
      <div class="block_body_list">
        <div id="tabla">
          <table width="100%" cellspacing="0" cellpadding="0" border="0" id="tabla_search">
            <thead>
              <tr>
                <th width="180" align="left"> E-mail </th>
                <th align="left">Nombre</th>
                <th width="110" align="left">Fecha de creaci&oacute;n</th>
                <th width="100" align="left">Fecha de envio</th>
                <th width="50" align="left">Estado</th>
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
                <td align="left"><?=$db_list->getXHTMLValue("sent_date_f")?></td>
                <td align="left"><?=$db_list->getXHTMLValue("creation_date_f")?></td>
                <td align="center"><img src="images/ico_state_<?=$db_list->getValue("id_status")?>.gif" width="16" height="7" alt="" /></td>
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
      </div>
    </div>
  </div>
  <div class="block_footer_list">
    <div class="cont_bg_block_footer_left">
      <div class="bg_block_footer_left_list"><span></span></div>
    </div>
    <div class="cont_bg_block_footer_right">
      <div class="bg_block_footer_right_list"><span></span></div>
    </div>
  </div>
</div>
</body>
</html>
