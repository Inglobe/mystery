<table border="0" cellspacing="0" cellpadding="0" class="box_imagenes">
  <tr>
    <td><table border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td><input type="file" name="data_<?=$nombre_foto?>" onchange="document.getElementById('cuadro_<?=$nombre_foto?>').src=this.value;document.<? echo "form_".$nombre_abm; ?>.borrar_<? echo $nombre_foto; ?>.disabled=false;" /></td>
      </tr>
      <tr>
        <td height="85" valign="bottom"><table  border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img id="cuadro_<?=$nombre_foto?>" src="<?
						if(${$nombre_foto}=="")
							echo"images/imagen_default.jpg";
						else
							echo "imagen.php?ruta=$path".${$nombre_foto}."&ancho=99&alto=74";
						?>" height="74" class="border_image" /></td>
              <td valign="bottom">&nbsp;&nbsp;
                  <input type="checkbox" name="borrar_<?=$nombre_foto?>" value="1"<?
						if(${$nombre_foto}=="")
							echo "disabled";
						   ?> onclick="if(this.checked){document.getElementById('cuadro_<?=$nombre_foto?>').prototype=document.getElementById('cuadro_<?=$nombre_foto?>').src;document.getElementById('cuadro_<?=$nombre_foto?>').src='images/imagen_default.jpg';document.<? echo "form_".$nombre_abm; ?>.data_<?=$nombre_foto?>.disabled = true;}else{document.<? echo "form_".$nombre_abm; ?>.data_<?=$nombre_foto?>.disabled = false;document.getElementById('cuadro_<?=$nombre_foto?>').src=document.getElementById('cuadro_<?=$nombre_foto?>').prototype;}" /></td>
              <td valign="bottom">Borrar&nbsp;foto</td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
