<?
  	  if(isset($nombre_abm)){
	  	  $nombre_form="form_".$nombre_abm;
	  }
	  if(!isset($fecha_defecto)){
	  	  $fecha_defecto=date("d/m/Y");
	  }
	  if(${$nombre_datebox} != "" ){
	  	  $fecha_defecto=${$nombre_datebox} = convertirFechaDesdeMySQL(${$nombre_datebox});;
	  }
	  if(${$nombre_datebox."_check"}==1){
	  	  $estado_checkbox="checked";
	  }
	  else{
	  	  $estado_checkbox="";
	  }

  	  ?>
  	  <div style="float:left;">
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
	  </div>
		<?
		if($permitir_nulo==true){
		?>
		<div style="float:left;">
			<input type="checkbox" onclick="document.<?=$nombre_form?>.<?=$nombre_datebox?>.disabled=!this.checked;" value="1" name="<?=$nombre_datebox?>_check" <?=$estado_checkbox?>  class="border_fondo_none" />
		</div>
		<?
  	  }
  	  unset($nombre_datebox,$fecha_defecto,$permitir_nulo);
  ?>