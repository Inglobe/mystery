<div id="radiobuttons">
  <div class="radiobutton">
    <input type="radio" id="<?=$this->nombre?>_si" name="<?=$this->nombre?>" value="1" <?
	  if($this->desactivar){
	?> disabled <?
	}
	  if($valor==1)
	  	echo "checked";
	?> />
  </div>
  <div class="label_radiobutton">
    <label for="<?=$this->nombre?>_si" style="color:#404040;" >Si</label>
  </div>
  <div class="radiobutton">
    <input type="radio" id="<?=$this->nombre?>_no" name="<?=$this->nombre?>" value="0" <?
	  if($this->desactivar){
	?> disabled <?
	}
	  if($valor==0)
	  	echo "checked";
	?> />
  </div>
  <div class="label_radiobutton">
    <label for="<?=$this->nombre?>_no" style="color:#404040;">No</label>
  </div>
  <div class="bug"><span></span></div>
</div>
