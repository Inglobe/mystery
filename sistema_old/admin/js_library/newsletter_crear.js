$('btn_importar').onclick = function() {
	$('editar_news').style.display = "none";
	$('importar_news').style.display = "";
	this.style.display = "none";
	$('btn_editar').style.display = "";

	return false;
}
$('btn_editar').onclick = function() {
	$('editar_news').style.display = "";
	$('importar_news').style.display = "none";
	this.style.display = "none";
	$('btn_importar').style.display = "";

	return false;
}

$('btn_crear').onclick = function() {
	var val = validar(document.getElementById('form_newsletter'));
	if(val){
		document.getElementById('tipo_accion').value='editar';
		document.form_newsletter.action='index.php';
		document.form_newsletter.target='_self';
		document.form_newsletter.submit();
	}
	return false;
}
$('btn_vista_preliminar').onclick = function(){
	$('tipo_accion').value='editar';
	document.form_newsletter.action='newsletters_preview.php';
	document.form_newsletter.target='_blank';
	document.form_newsletter.submit();
	return false;
}

$('filtro_fecha_check').onclick = function(){
	document.form_newsletter.filtro_fecha.disabled=!this.checked;
}

$('btn_crear_importar').onclick = function() {
	$('tipo_accion').value='importar';
	document.form_newsletter.action='index.php';
	document.form_newsletter.target='_self';
	document.form_newsletter.submit();
	return false;
}

