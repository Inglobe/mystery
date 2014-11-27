<div class="box">
  <input type="file" name="<?=$this->nombre?>" onchange="comprobar_extension(this);document.getElementById('cuadro_<?=$this->nombre?>').src=this.value;document.<?=$this->nombre_form?>.borrar_<?=$this->nombre?>.disabled=false;" />
  <img id="cuadro_<?=$this->nombre?>" style="float:left; margin-top:5px;" src="<?
			if($valor=="")
				echo"imagenes/imagen_default.jpg";
			else
				echo "imagen.php?ruta=".$ruta.$valor."&ancho=100";
			?>" alt="" width="100" class="borde_imagen" />
  <div style="float:left;">
    <input type="hidden" name="path_<?=$this->nombre?>" value="<?=$ruta?>" />
    <input type="checkbox" id="check_foto_<?=$this->nombre?>" name="borrar_<?=$this->nombre?>" value="1"<?
			if($valor=="")
				echo "disabled";
			   ?> onclick="if(this.checked){document.getElementById('cuadro_<?=$this->nombre?>').prototype=document.getElementById('cuadro_<?=$this->nombre?>').src;document.getElementById('cuadro_<?=$this->nombre?>').src='imagenes/imagen_default.jpg';}else{document.getElementById('cuadro_<?=$this->nombre?>').src=document.getElementById('cuadro_<?=$this->nombre?>').prototype;}" />
    <label for="check_foto_<?=$this->nombre?>">Borrar foto</label>
  </div>
</div>
