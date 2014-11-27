<textarea name="<?=$this->nombre?>"

 cols="<?=$columnas?>" rows="<?=$filas?>"<?
if($this->id_javascript != ""){
?> id="<?=$this->id_javascript?>"<?
}
if($this->on_change != ""){
?> onchange="<?=$this->on_change?>"<?
}
if($this->css_class != ""){
?> class="<?=$this->css_class?>"
<?
}
if($this->desactivar){
?> disabled<?
}
?>><?=$valor?></textarea>
<script type="text/javascript">
//<![CDATA[
	r.field.<?=$this->nombre?> = "<?=$caracteres_aceptados?>";
<?
	if($mascara != ""){
?>
	r.mask.<?=$this->nombre?> = "<?=$mascara?>";
<?
	}
?>
//]]>
</script>