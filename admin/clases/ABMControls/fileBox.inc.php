<div class="box"  style="float:left; height: 1%;">
  <label for="<?=$this->nombre?>"><?
	if($valor=="")
		echo "--ninguno--";
	else
		echo "<a href=\"".$ruta.$valor."\" target=\"_blank\">".$ruta.$valor."</a>";
?></label>
  <input type="hidden" name="path_<?=$this->nombre?>" value="<?=$ruta?>" />
  <input type="file" id="<?=$this->nombre?>" name="<?=$this->nombre?>" />.
  <div style="margin-top: 10px; float:left;">
  	<div style="float:left;">
    	<input type="checkbox" id="check_foto_<?=$this->nombre?>" name="borrar_<?=$this->nombre?>" value="1"<?
			if($valor=="")
				echo "disabled";
			   ?> onclick="if(this.checked){document.getElementById('cuadro_<?=$this->nombre?>').prototype=document.getElementById('cuadro_<?=$this->nombre?>').src;document.getElementById('cuadro_<?=$this->nombre?>').src='imagenes/imagen_default.jpg';}else{document.getElementById('cuadro_<?=$this->nombre?>').src=document.getElementById('cuadro_<?=$this->nombre?>').prototype;}" />
	</div>
	<div style="width:35px;float:left;">
    	<label for="check_foto_<?=$this->nombre?>">Borrar</label>
    </div>
  </div>
</div>