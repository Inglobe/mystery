  <?
  	  if(isset($nombre_abm)){
	  	  $nombre_form="form_".$nombre_abm;
	  }
	  ${$nombre_datebox} = convertirFechaDesdeMySQL(${$nombre_datebox});
  ?>
  <table border="0" cellspacing="0" cellpadding="0">
    <td><input name="date_<?=$nombre_datebox?>" value="<?=${$nombre_datebox}?>" type="text" class="textbox_date" size="10" onKeypress="event.returnValue = false;" onfocus="blur()" /></td>
    <td width="20" align="right"><a href="javascript:show_calendar('<?=$nombre_form?>.date_<?=$nombre_datebox?>');"><img src="skins/azul/imagenes/show-calendar.png" alt="Calendar" width="16" height="16" border="0"/></a></td>
  </table>
  <?
  	  unset($nombre_datebox);
  ?>