<div style="width:125px;">
 <?
	  if($valor == ""){
	  	  $valor=date("d/m/Y");
	  }
	  if($valor_check==1){
	  	  $estado_checkbox="checked";
	  }
	  else{
	  	  $estado_checkbox="";
	  }
?>
	<div style="width:100px;float:left;">
	    <script type="text/javascript">
	  	  FSfncWriteFieldHTML("<?=$this->nombre_form?>","<?=$this->nombre?>","<?=$valor?>",100,"clases/ABMControls/datePicker/images/FSdateSelector/","<?=strtoupper($_SESSION["idioma"])?>",true,true);
	  	<?
	    if($this->desactivar && $valor_check != 1){
		?>
	      document.<?=$this->nombre_form?>.<?=$this->nombre?>.disabled=true;
	    <?
	    }
	    ?>
		</script>
	</div>
	<?
	if($permitir_nulo==true){
	?>
  	<div style="width:20px;float:left;">
		<input type="checkbox" onclick="document.<?=$this->nombre_form?>.<?=$this->nombre?>.disabled=!this.checked;" value="1" name="<?=$this->nombre?>_check" <?=$estado_checkbox?> class="border_fondo_none" />
	</div>
	<?
	}
	?>
</div>