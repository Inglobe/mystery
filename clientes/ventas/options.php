<?php

	//Titulacion ABM
	$titulo_abm 	= 'Sistema';
	$sub_titulo_abm = 'Optiones';
	$titulo_opcion 	= 'Modificar';
	$nombre_abm 	= 'Opciones';
	
	if($data->post('re',DATA_EX_TYPE_INT,false) == 1){
		
		$mostrar_feed = '';
		
		$parametros->newsletter_from_email = $data->post('newsletter_from_email');
		$parametros->newsletter_from_name = $data->post('newsletter_from_name');
		$parametros->newsletter_reply_email = $data->post('newsletter_reply_email');
		$parametros->nro_envios_lote = $data->post('nro_envios_lote');
		
	}else{
		$mostrar_feed = 'none';
	}
?>
<!--
<script language="javascript" type="text/javascript">

	function validar_parametros(f){
		if(f.id_grupo_news_site.value == 0){
			alert("Seleccione un Grupo.");
			f.id_grupo_news_site.focus();
			return false;
		}else{
			return true;
		}
	}

</script>
-->

<div id="page_tittle_color" class="gradient_theme">
  <div id="ico"><img src="images/ico_parameters-trans.png" width="57" height="50" alt="" /></div>
  <h1 id="tit_home">Opciones</h1>
</div>
<div id="conteiner_feed_add" style="display: <?=$mostrar_feed?>;">
  <div id="feed_add">
    <div id="text_feed">Parametros web</div>
    <img src="images/ico_info.jpg" alt="" /> </div>
</div>
<div class="block">
  <form id="form_parametros" name="form_parametros" method="post" action="" onsubmit="return validar_parametros(this)">
    <input type="hidden" name="re" value="1">
    <div class="separator">
      <h3 class="title_color">Formularios de Contacto web</h3>
      <span></span></div>
    <div class="input_container">
      <div class="input">
        <label>E-mail From Newsletter</label>
        <input type="text" name="newsletter_from_email" size="40" value="<?=$parametros->newsletter_from_email?>" />
      </div>
      <div class="input_description">Formulario de contacto, es el que el usuario completa para solicitar informacion sobre algun inbueble espcifico o directamente una consulta. Tenga en cuenta definir quien es el responsable de contacto para tener una eficiente respuesta.</div>
    </div>
    <div class="input_container">
      <div class="input">
        <label>E-mail From Name</label>
        <input type="text" name="newsletter_from_name" size="40" value="<?=$parametros->newsletter_from_name?>" />
      </div>
      <div class="input_description">Formulario de contacto, es el que el usuario completa para solicitar informacion sobre algun inbueble espcifico o directamente una consulta. Tenga en cuenta definir quien es el responsable de contacto para tener una eficiente respuesta.</div>
    </div>
    <div class="input_container">
      <div class="input">
        <label>E-mail Reply Newsletter</label>
        <input type="text" name="newsletter_reply_email" size="40" value="<?=$parametros->newsletter_reply_email?>" />
      </div>
      <div class="input_description">Formulario de contacto, es el que el usuario completa para solicitar informacion sobre algun inbueble espcifico o directamente una consulta. Tenga en cuenta definir quien es el responsable de contacto para tener una eficiente respuesta.</div>
    </div>
    <div class="input_container">
      <div class="input">
        <label>Env&iacute;os por lote</label>
        <input type="text" name="nro_envios_lote" size="3" value="<?=$parametros->nro_envios_lote?>" />
      </div>
      <div class="input_description">Formulario de contacto, es el que el usuario completa para solicitar informacion sobre algun inbueble espcifico o directamente una consulta. Tenga en cuenta definir quien es el responsable de contacto para tener una eficiente respuesta.</div>
    </div>
    <div class="separator">
      <h3 class="title_color">Varios</h3>
      <span></span></div>
      <div class="input_container">
      <div class="input">
        <label>Terminos y Condiciones</label>
        <textarea cols="100" rows="15"></textarea>
      </div>
      <div class="input_description">Formulario de contacto, es el que el usuario completa para solicitar informacion sobre algun inbueble espcifico o directamente una consulta. Tenga en cuenta definir quien es el responsable de contacto para tener una eficiente respuesta.</div>
    </div>
    <div id="cont_btns_ok_cancel">
      <div id="btns_ok_cancel">
        <input name="Submit" type="submit" value="Ok" class="gradient_theme" />
      </div>
    </div>
  </form>
</div>
