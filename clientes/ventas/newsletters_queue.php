<div id="title">
  <h1> <span>Sistema</span><span class="title_separator">/</span><span class="dark_color">Newsletters</span><span class="title_separator">/</span><span class="light_color">Pendientes</span> </h1>
</div>
<div id="tabs">
    <div class="tab"><a href="index.php?put=newsletters_sents"><span>Enviados</span><img src="images/ico_tab_sents.png" width="27" height="25" alt="" /></a>
    </div>
    <div class="union_tab"><span></span></div>
    <div class="tab"><a href="index.php?put=newsletters_queue" class="active"><span>Pendientes</span><img src="images/ico_tab_queue.png" width="26" height="25" alt="" /></a>
    </div>
    <div class="end_tab"><span></span></div>
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
                <th width="1%" align="left">&nbsp;</th>
                <th width="70" align="left"> Fecha </th>
                <th align="left"> Asunto </th>
                <th width="1%">&nbsp;</th>
                <th width="1%">&nbsp;</th>
                <th width="1%">&nbsp;</th>
              </tr>
            </thead>
            <tbody>
			<?
			$idd = $data->get("idd",DATA_EX_TYPE_INT);
			if(!empty($idd)){
				$dbd = new database;
				$dbd->query("DELETE FROM newsletters WHERE id_newsletter = ".$idd);
			}
			
			$sql = "SELECT
						n.*,
						DATE_FORMAT(sent_date,'%d/%m/%Y') AS sent_date_f
					FROM
						newsletters n
					WHERE 
						n.sent = 0
					ORDER BY
						n.sent_date DESC
					";
			$db_list = new database_format;
			$db_list->query($sql);
			$row_color = "dark_row";
			while($db_list->fetch()){
				$row_color = ($row_color=="light_row"?"dark_row":"light_row");
				$id_newsletter = $db_list->getValue("id_newsletter");
			?>
              <tr class="<?=$row_color?>">
                <td align="left"><img src="images/ico_mail.png" width="15" height="15" alt="" /></td>
                <td align="left"><a href="newsletters_view.php?id=<?=$id_newsletter?>" target="_blank"><?=$db_list->getXHTMLValue("sent_date_f")?></a></td>
                <td align="left"><a href="newsletters_view.php?id=<?=$id_newsletter?>" target="_blank"><?=$db_list->getXHTMLValue("subject")?></a></td>
                <td><a href="newsletters_save.php?id=<?=$id_newsletter?>"><img src="images/ico_save.png" width="11" height="15" alt="" /></a></td>
                <td><a href="index.php?put=newsletters_send&amp;id=<?=$id_newsletter?>"><img src="images/ico_send.png" width="19" height="15" alt="" /></a></td>
                <td><a onclick="return confirmDelete();" href="index.php?put=newsletters_queue&amp;idd=<?=$db_list->getValue("id_newsletter")?>"><img border="0" alt="Borrar" src="images/ico_delete.gif"></a></td>
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
