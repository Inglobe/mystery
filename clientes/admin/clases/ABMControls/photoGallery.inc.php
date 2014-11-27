<form name="form_gallery_<?=$this->nombre?>" id="form_gallery_<?=$this->nombre?>" method="post" action="post">
  <input type="hidden" name="check_hash" value="<?=md5(rand(0,9999999999))?>" />
</form>
<div id="multiple_files"></div>
<script type="text/javascript">
//<![CDATA[
	$('#multiple_files').agileUploader({
		submitRedirect: 'results.php',
		formId: 'form_gallery_<?=$this->nombre?>',
		flashVars: {
			firebug: true,
			form_action: 'clases/ABMcontrols/photoGalleryUpload.ajax.php',
			max_height: 800,
			max_width: 600,
			file_limit: 10,
			preview_max_height: 100,
			preview_max_width: 150,
			max_post_size: (8000 * 1024)
		}
	});
//]]>
</script>
<a href="#" onClick="document.getElementById('agileUploaderSWF').submit();">Submit</a>
<div class="separator">
  <h3 class="title_color">Im&aacute;genes agregadas</h3>
  <span></span></div>
<ul id="photo_gallery_cont">
<?
$this->query("SELECT * FROM fotos WHERE rel_id = ".$id_rel." AND abm LIKE '".$abm."' ORDER BY orden ASC");
while($this->fetch()){
?>
  <li id="fotos_<?=$this->getValue("id_foto")?>">
	<div class="img_conteiner"><img src="imagen.php?ruta=../images/gallery/photos/<?=rawurlencode($this->getValue("foto"))?>&amp;ancho=160&amp;alto=120&amp;mantener_ratio=1" alt="" width="160" height="120" /></div>
    <input type="text" value="<?=$this->getXHTMLValue("descripcion")?>" name="epigrafe_<?=$this->getValue("id_foto")?>" size="24" />
	<a href="#" onclick="return deletePhoto(<?=$this->getValue("id_foto")?>)" ><img src="images/ico-delete-trans.png" width="17" height="17" alt="" class="btn_delete" /></a>
  </li>
<?
}
?>
</ul>
<script type="text/javascript">
//<![CDATA[
	
	$("#photo_gallery_cont").sortable({
		opacity: 0.6,
		cursor: "move",
		update: function(){
			var order = $(this).sortable("serialize");
			jQuery.post("clases/ABMControls/photoGallerySort.ajax.php", order, function(theResponse){
				// Callback code here
			});
		}
	});
	
	function deletePhoto(id){
		return confirm("Esta seguro de borrar?");
	}
//]]>
</script>