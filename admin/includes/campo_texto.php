<?
switch($tipo){
case "normal":
?>
<input class="<?=$nombre_estilo?>" name="<?=$nombre_campo?>" id="<?=$id_javascript?>" maxlength="<?=$tamanio_texto_maximo?>" onchange="<?=$onchange_javascript?>" type="text" size="<?=$tamanio_texto?>" value="<?=${$nombre_campo}?>" onkeypress="<?=$onkeypress_javascript?>" />
<?
break;
case "textarea":
?>
<textarea class="<?=$nombre_estilo?>"  name="<?=$nombre_campo?>" id="<?=$id_javascript?>" onchange="<?=$onchange_javascript?>" cols="<?=$columnas_textarea?>" rows="<?=$filas_textarea?>"><?=${$nombre_campo}?></textarea>
<?
break;
case "richtext":
	$oFCKeditor = new FCKeditor($nombre_campo);
	$oFCKeditor->BasePath="../includes/fckeditor/";
	$oFCKeditor->Config['DefaultLanguage']=$idioma;
	$oFCKeditor->Value=${$nombre_campo};
	$oFCKeditor->Height=$alto_richtext;
	$oFCKeditor->Create();
break;
}
unset($nombre_estilo,$alto_richtext,$nombre_campo,$id_javascript,$columnas_textarea,$filas_textarea,$tipo,$tamanio_texto,$tamanio_texto_maximo,$onchange_javascript,$onkeypress_javascript);
?>