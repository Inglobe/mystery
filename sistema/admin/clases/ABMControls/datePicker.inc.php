<div>
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
	<div style="float:left;">
    	<input name="<?=$this->nombre?>" id="<?=$this->nombre?>" value="<?=$valor?>" onfocus="this.blur();" />
        <a class="dateButton" id="<?=$this->nombre?>_popup">Mostrar calendario</a>
	    <script type="text/javascript">
			var call_<?=$this->nombre?> = new loom.ui.Calendar(
				'<?=$this->nombre?>', {
				triggerElement : '<?=$this->nombre?>_popup',
				dateFormat: '%d/%m/%Y'
			});
		</script>
	</div>
</div>