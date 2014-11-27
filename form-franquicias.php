<div id="header_seccion"> <img src="imagenes/img_header_contacto.png" width="182" height="157" alt="" style="padding-top:60px; padding-left:70px;" />
  <h1><span>Franquicias</span></h1>
  <p style="padding-top:16px;">Complet&aacute; el siguiente formulario y nos pondremos en contacto con Ud.<br />
para informarle acerca de los alcances del sistema de franquicias.<strong></strong><br />
  </p>
</div>
<div id="fondo_secciones">
  <div id="col_izq_seccion">
    <p class="texto_resaltado">Dejanos tus datos personales y te agregaremos a nuestra base de datos de potenciales Shoppers.</p>
    <?php include("datos_contacto.inc.php"); ?>
  </div>
  <div id="col_der_seccion">
    <div id="form_contacto">
      <form action="index.php?put=form-franquicias-feed" method="post" id="form_contactos" onsubmit="return checkForm(this.id)">
        <input type="hidden" name="nombre_empresa" value="Mystery sur" />
        <input type="hidden" name="nombre_form" value="Contacto desde el sitio" />
        <input type="hidden" name="email_asunto" value="Contacto por franquicia desde el sitio" />
        <input type="hidden" name="email_usuario_asunto" value="Gracias por contactarse" />
        <div class="campo_form">
          <label><strong>*</strong> Nombres:</label>
        </div>
        <div>
          <input type="hidden" name="campo_nombre" value="Nombre" />
          <input name="nombre" type="text" class="required" value="" style="width:520px;" />
        </div>
        <div class="campo_form">
          <label><strong>*</strong>Apellido:</label>
        </div>
        <div>
          <input type="hidden" name="campo_apellido" value="Apellido" />
          <input name="apellido" type="text" class="required" value="" style="width:520px;" />
        </div>
        <div class="campo_form">
          <label><strong>*</strong>Pa&iacute;s:</label>
        </div>
        <div>
          <input type="hidden" name="campo_pais" value="Pa&iacute;s" />
          <input name="empresa" type="text" class="required" value="" style="width:520px;" />
        </div>
        <div class="campo_form">
          <label><strong>*</strong>Provincia:</label>
        </div>
        <div>
          <input type="hidden" name="campo_provincia" value="Provincia" />
          <input name="cargo" type="text" class="required" value="" style="width:520px;" />
        </div>
        <div class="campo_form">
          <label><strong>*</strong>Ciudad:</label>
        </div>
        <div>
          <input type="hidden" name="campo_ciudad" value="Ciudad" />
          <input name="cargo" type="text" class="required" value="" style="width:520px;" />
        </div>
        <div class="campo_form">
          <label><strong>*</strong> E-mail:</label>
        </div>
        <div>
          <input type="hidden" name="campo_email" value="E-mail" />
          <input name="email" type="text" class="required email" value="" style="width:520px;" />
        </div>
        <div class="campo_form">
          <label><strong>*</strong> Tel&eacute;fono:</label>
        </div>
        <div>
          <input type="hidden" name="campo_telefono" value="Tel&eacute;fono" />
          <input name="telefono" type="text" class="required numeric" value="" style="width:520px;" />
        </div>
        <div class="campo_form">
          <label><strong>*</strong> Consulta:</label>
        </div>
        <div>
          <input type="hidden" name="campo_mensaje" value="Mensaje" />
          <textarea name="mensaje" rows="5" class="required" style="width:520px;" cols="1"></textarea>
        </div>
        <div class="campo_form">
          <label><strong>* Datos requeridos</strong></label>
        </div>
        <div id="btn_enviar" style="margin-top:10px; padding-right:50px; text-align:right;">
          <input name="" type="image" src="imagenes/btn_enviar_pie.png" />
        </div>
      </form>
    </div>
  </div>
</div>
