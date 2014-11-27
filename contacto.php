<div id="header_seccion"> <img src="imagenes/img_header_contacto.png" width="182" height="157" alt="" style="padding-top:60px; padding-left:70px;" />
  <h1><span>Contacto</span></h1>
  <p style="padding-top:16px;">Complet&aacute; el formulario y dejanos tus consultas. <br />
    Te contestaremos a la brevedad, <strong>muchas gracias.</strong><br />
  </p>
</div>
<div id="fondo_secciones">
  <div id="col_izq_seccion">
    <p class="texto_resaltado">Complet&aacute; el formulario <br />
      y dejanos tus consultas. <br />
      Te contestaremos a la brevedad, muchas gracias.</p>
    <?php include("datos_contacto.inc.php"); ?>
  </div>
  <div id="col_der_seccion">
    <div id="form_contacto">
      <form action="index.php?put=contacto-feed" method="post" id="form_contactos" onsubmit="return checkForm(this.id)">
        <input type="hidden" name="nombre_empresa" value="Mystery sur" />
        <input type="hidden" name="nombre_form" value="Contactos" />
        <input type="hidden" name="email_asunto" value="<? if($_GET["prueba"]==1) {?>Solicito auditor&iacute;a de prueba sin cargo<? } else {?>Contacto desde el sitio<? } ?>" />
        <input type="hidden" name="email_usuario_asunto" value="Gracias por contactarse" />
        <? if($_GET["prueba"]==1) {?><h3>Solicitar auditor&iacute;a de prueba sin cargo</h3><? } ?>
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
          <label><strong>*</strong>Empresa:</label>
        </div>
        <div>
          <input type="hidden" name="campo_empresa" value="Empresa" />
          <input name="empresa" type="text" class="required" value="" style="width:520px;" />
        </div>
        <div class="campo_form">
          <label><strong>*</strong>Cargo:</label>
        </div>
        <div>
          <input type="hidden" name="campo_cargo" value="Cargo" />
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
