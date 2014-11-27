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
    	<input name="<?=$this->nombre?>" id="<?=$this->nombre?>" value="<?=$valor?>" style="margin-right:15px; width:60px;" />
        <script type="text/javascript">
			$(function(){
				// Datepicker
				$(function() {
				$( "#<?=$this->nombre?>" ).datepicker();
				});
			});
		</script>
	</div>
</div>