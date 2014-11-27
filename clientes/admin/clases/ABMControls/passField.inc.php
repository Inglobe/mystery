<input type="password" name="<?=$this->nombre?>" value="<?=$valor?>"<?
if($this->css_class != ""){
?> class="<?=$this->css_class?>"<?
}
?> size="26" maxlength="26"<?
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
	r.field.<?=$this->nombre?> = "\\w";
	r.mask.<?=$this->nombre?> = "";
//]]>
</script>