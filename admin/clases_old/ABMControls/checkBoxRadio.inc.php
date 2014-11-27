<div class="recuadrito">
	<div style="float:left;">
	  <input type="radio" id="<?=$this->nombre?>_si" name="<?=$this->nombre?>" value="1" <?
	  if($this->desactivar){
	?> disabled <?
	}
	  if($valor==1)
	  	echo "checked";
	?> />
	</div>
	<div style="float:left; margin-top:3px;">
	  <label for="<?=$this->nombre?>_si" >Si</label>
	</div>
	<div style="float:left;">
	  <input type="radio" id="<?=$this->nombre?>_no" name="<?=$this->nombre?>" value="0" <?
	  if($this->desactivar){
	?> disabled <?
	}
	  if($valor==0)
	  	echo "checked";
	?> />
	</div>
	<div style="float:left; margin-top:3px;">
	  <label for="<?=$this->nombre?>_no">No</label>
	</div>
	<div class="bug"><span></span></div>
</div>