<div class="box">
  <label for="<?=$this->nombre?>"><?
	if($valor=="")
		echo "--ninguno--";
	else
		echo "<a href=\"".$ruta.$valor."\" target=\"_blank\">".$ruta.$valor."</a>";
?></label>
  <input type="hidden" name="path_<?=$this->nombre?>" value="<?=$ruta?>" />
  <input type="file" id="<?=$this->nombre?>" name="<?=$this->nombre?>" />
</div>