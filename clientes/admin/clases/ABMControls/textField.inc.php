<input type="text" name="<?=$this->nombre?>" value="<?=$valor?>"<?
if($this->css_class != ""){
?> class="<?=$this->css_class?>"<?
}
if($ancho != 0){
?> size="<?=$ancho?>"<?
}
if($maximo != 0){
?> maxlength="<?=$maximo?>"<?
}
if($this->id_javascript != ""){
?> id="<?=$this->id_javascript?>"<?
}
if($this->on_change != ""){
?> onchange="<?=$onchange_javascript?>"<?
}
if($this->on_keypress != ""){
?> onkeypress="<?=$onkeypress_javascript?>"<?
}
if($this->desactivar){
?> disabled<?
}
?>
 />
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