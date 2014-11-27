<textarea name="<?=$this->nombre?>"

 cols="<?=$columnas?>" rows="<?=$filas?>"<?
if(isset($this->id_javascript) && ($this->id_javascript != "")){
?> id="<?=$this->id_javascript?>"<?
}
if(isset($this->on_change) && ($this->on_change != "")){
?> onchange="<?=$this->on_change?>"<?
}
if(isset($this->css_class) && ($this->css_class != "")){
?> class="<?=$this->css_class?>"
<?
}
if(isset($this->desactivar) && $this->desactivar){
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