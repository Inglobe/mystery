 <?
  	  if(isset($nombre_abm)){
	  	  $nombre_form="form_".$nombre_abm;
	  }
	  if(!isset($fecha_defecto)){
	  	  $fecha_defecto=date("d/m/Y");
	  }
	  if(${$nombre_datebox} != "" ){
	  	  $fecha_defecto=${$nombre_datebox};
	  }
	  if(${$nombre_datebox."_check"}==1){
	  	  $estado_checkbox="checked";
	  }
	  else{
	  	  $estado_checkbox="";
	  }
 ?>
 <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
      <?
      if($permitir_nulo==true){
  	  ?>
      <td><input type="checkbox" onclick="document.<?=$nombre_form?>.<?=$nombre_datebox?>.disabled=!this.checked;" value="1" name="<?=$nombre_datebox?>_check" <?=$estado_checkbox?>  class="border_fondo_none" /></td>
      <?
  	  }
  	  ?>
	  <td>
	    <script language="javascript">
	  	  FSfncWriteFieldHTML("<?=$nombre_form?>","<?=$nombre_datebox?>","<?=$fecha_defecto?>",100,"includes/date_picker/images/FSdateSelector/","<?=strtoupper($idioma)?>",true,true);
	  	<?
	    if($desactivar_checkbox==true && ${$nombre_datebox."_check"} != 1){
		?>
	      document.<?=$nombre_form?>.<?=$nombre_datebox?>.disabled=true;
	    <?
	    }
	    ?>
		</script>
	  </td>
    </tr>
  </table>
  <?
  	  unset($nombre_datebox,$fecha_defecto,$permitir_nulo);
  ?>
