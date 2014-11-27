<div id="page_tittle">
  <div id="ico"><img src="images/ico_soporte_tit-trans.png" width="47" height="50" alt="" /></div>
  <h1>Soporte</h1>
</div>
<div class="block">
  <div id="form">
    <form action="index.php?put=support-feed" method="post" id="form_contactos" onsubmit="return checkForm(this.id)">
      <input type="hidden" name="nombre_empresa" value="Mystery Sur" />
      <input type="hidden" name="nombre_form" value="Contactos" />
      <input type="hidden" name="email_asunto" value="Contacto desde el sistema de clientes" />
      <input type="hidden" name="email_usuario_asunto" value="Gracias por contactarse" />
      <div class="field_form">
        <label><strong>*</strong> Nombres</label>
      </div>
      <div class="input_form">
        <input type="hidden" name="campo_nombre" value="Nombre" />
        <input name="nombre" type="text" class="required" value="" size="80" />
      </div>
      <div class="field_form">
        <label><strong>*</strong>Apellido:</label>
      </div>
      <div class="input_form">
        <input type="hidden" name="campo_apellido" value="Apellido" />
        <input name="apellido" type="text" class="required" value="" size="80"/>
      </div>
      <div class="field_form">
        <label><strong>*</strong> E-mail:</label>
      </div>
      <div class="input_form">
        <input type="hidden" name="campo_email" value="E-mail" />
        <input name="email" type="text" class="required email" value="" size="80" />
      </div>
      <div class="field_form">
        <label><strong>*</strong> Tel&eacute;fono</label>
      </div>
      <div class="input_form">
        <input type="hidden" name="campo_telefono" value="Tel&eacute;fono" />
        <input name="telefono" type="text" class="required numeric" value="" size="80" />
      </div>
      <div class="field_form">
        <label><strong>*</strong> Consulta:</label>
      </div>
      <div class="input_form">
        <input type="hidden" name="campo_mensaje" value="Mensaje" />
        <textarea name="mensaje" rows="5" class="required" cols="88"></textarea>
      </div>
       <div class="field_form">
        <label><strong>* Datos requeridos</strong></label>
      </div>
      <div id="cont_btns_ok_cancel">
      <div id="btns_ok_cancel">
        <input type="submit" class="gradient_theme" value="Enviar" name="Submit">
      </div>
    </div>
    </form>
  </div>
  <div id="form_data">
    <h3>Datos de contacto</h3>
    <p>Luis de Tejeda 3962 local 3<br />
    Cerro de las Rosas, Cordoba, Argentina<br />
    C&oacute;rdoba -  Argentina<br />
    Tel: +54 351 5985002<br />
<a href="mailto:Info@mysterysur.com.ar">Info@mysterysur.com.ar</a></p>
  </div>
</div>
