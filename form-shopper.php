<div id="header_seccion"> <img src="imagenes/img_header_contacto.png" width="182" height="157" alt="" style="padding-top:60px; padding-left:70px;" />
  <h1 style="font-size:40px; padding-top:20px;"><span>Quer&eacute;s ser un <strong>Mystery Shopper</strong>?</span></h1>
  <p style="padding-top:16px;">Si consider&aacute;s que ten&eacute;s el perfil para ser un Shopper, dejanos tus referencias <br />
    completando el siguiente formulario y te tendremos en cuenta. Muchas gracias.<strong></strong><br />
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
      <form action="index.php?put=form-shopper-feed" method="post" id="form_contactos" onsubmit="return checkForm(this.id)">
        <input type="hidden" name="nombre_empresa" value="Mystery sur" />
        <input type="hidden" name="nombre_form" value="Contacto desde el sitio" />
        <input type="hidden" name="email_asunto" value="Queres ser Mystery Shopper" />
        <input type="hidden" name="email_usuario_asunto" value="Gracias por contactarse" />
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label><strong>*</strong> Nombres:</label>
            <input type="hidden" name="campo_nombre" value="Nombre" />
            <input name="nombre" type="text" class="required" value="" style="width:250px;" />
          </div>
          <div style="float:left;">
            <label><strong>*</strong>Apellido:</label>
            <input type="hidden" name="campo_apellido" value="Apellido" />
            <input name="apellido" type="text" class="required" value="" style="width:250px;" />
          </div>
        </div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label><strong>*</strong>Pa&iacute;s:</label>
            <input type="hidden" name="campo_pais" value="Pa&iacute;s" />
            <input name="pais" type="text" class="required" value="" style="width:250px;" />
          </div>
          <div style="float:left;">
            <label><strong>*</strong>Provincia:</label>
            <input type="hidden" name="campo_pid" value="Provicia" />
            <select name="pid" id="cmb_prov" style="width:250px;" class="required" >
          <option value="">--seleccione--</option>
        <?
	  	
		$consulta = "SELECT 
					p.*
				FROM 
					provincias p
				ORDER BY 
					p.nombre ASC
						";
		$resultado = mysql_query($consulta);
		while($fila_provincia = mysql_fetch_array($resultado)){
?>
          <option value="<?=$fila_provincia["id"]?>">
         <?=$fila_provincia["nombre"]?>
          </option>
          <?
        }
        ?>
        </select>
          </div>
        </div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label><strong>*</strong>Localidad:</label>
            <input type="hidden" name="campo_lid" value="Ciudad" />
            <select name="lid" id="cmb_loc" class="required" style="width:250px;">
              <option value="">Localidad</option>
            </select>
          </div>
          <div style="float:left;">
            <label><strong>*</strong>Barrio:</label>
            <input type="hidden" name="campo_barrio" value="Barrio" />
            <input name="barrio" type="text" class="required" value="" style="width:250px;" />
          </div>
        </div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label><strong>*</strong>Calle:</label>
            <input type="hidden" name="campo_calle" value="Calle" />
            <input name="calle" type="text" class="required" value="" style="width:200px;" />
          </div>
          <div style="float:left; padding-right:20px;">
            <label><strong>*</strong>N&ordm;:</label>
            <input type="hidden" name="campo_numero" value="N&ordm;" />
            <input name="numero" type="text" class="required" value="" style="width:55px;" />
          </div>
          <div style="float:left; padding-right:20px;"">
            <label>Departamento:</label>
            <input type="hidden" name="campo_departamento" value="Departamento" />
            <input name="departamento" type="text" value="" style="width:100px;" />
          </div>
          <div style="float:left;">
            <label>Edificio:</label>
            <input type="hidden" name="campo_edificio" value="Edificio" />
            <input name="edificio" type="text" value="" style="width:100px;" />
          </div>
        </div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>Casa:</label>
            <input type="hidden" name="campo_casa" value="Casa" />
            <input name="casa" type="text" value="" style="width:165px;" />
          </div>
          <div style="float:left; padding-right:20px;">
            <label>Lote:</label>
            <input type="hidden" name="campo_lote" value="Lote" />
            <input name="lote" type="text" value="" style="width:50px;" />
          </div>
          <div style="float:left; padding-right:20px;">
            <label><strong>*</strong>Cod. Postal:</label>
            <input type="hidden" name="campo_cp" value="CP" />
            <input name="cp" type="text" class="required numeric" value="" style="width:100px;" />
          </div>
          <div style="float:left;">
            <label><strong>*</strong> Tel&eacute;fono Movil</label>
            <input type="hidden" name="campo_telefono_movil" value="Tel&eacute;fono Movil" />
            <input name="telefono_movil" type="text" class="required numeric" value="" style="width:140px;" />
          </div>
        </div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>Tel&eacute;fono Fijo</label>
            <input type="hidden" name="campo_telefono" value="Tel&eacute;fono" />
            <input name="telefono" type="text" class="numeric" value="" style="width:125px;" />
          </div>
          <div style="float:left; padding-right:20px;">
            <label><strong>*</strong> E-mail:</label>
            <input type="hidden" name="campo_email" value="E-mail" />
            <input name="email" type="text" class="required email" value="" style="width:150px;" />
          </div>
          <div style="float:left; padding-right:20px; width:230px;">
            <label>Fecha de nacimiento:</label>
            <input type="hidden" name="campo_dia" value="D&iacute;a" />
            <select name="dia" id="select1" class="required">
              <option value="01">01</option>
              <option value="02">02</option>
              <option value="03">03</option>
              <option value="04">04</option>
              <option value="05">05</option>
              <option value="06">06</option>
              <option value="07">07</option>
              <option value="08">08</option>
              <option value="09">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
            <input type="hidden" name="campo_mes" value="Mes" />
            <select name="mes" id="select2" class="required">
              <option value="Enero">Enero</option>
              <option value="Febrero">Febrero</option>
              <option value="Marzo">Marzo</option>
              <option value="Abril">Abril</option>
              <option value="Mayo">Mayo</option>
              <option value="Junio">Junio</option>
              <option value="Julio">Julio</option>
              <option value="Agosto">Agosto</option>
              <option value="Septiembre">Septiembre</option>
              <option value="Octubre">Octubre</option>
              <option value="Noviembre">Noviembre</option>
              <option value="Diciembre">Diciembre</option>
            </select>
            <input type="hidden" name="campo_anio" value="A&ntilde;o" />
            <select name="anio" id="select3" class="required">
              <?php
          for($i=1940;$i<=date("Y",time())-10;$i++){ 
          ?>
              <option value="<?=$i?>">
              <?=$i?>
              </option>
              <?php
          } 
          ?>
            </select>
          </div>
        </div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;"">
            <label><strong>*</strong> N&ordm; de documento</label>
            <input type="hidden" name="campo_dni" value="N&ordm; de documento" />
            <input name="dni" type="text" class="required numeric" value="" style="width:125px;" />
          </div>
          <div style="float:left; padding-right:20px;">
            <label>MSN:</label>
            <input type="hidden" name="campo_msn" value="MSN" />
            <input name="msn" type="text" value="" style="width:105px;" />
          </div>
          <div style="float:left; padding-right:20px;">
            <label>pin Blackberry:</label>
            <input type="hidden" name="campo_blackberry" value="pin Blackberry" />
            <input name="blackberry" type="text" value="" style="width:105px;" />
          </div>
          <div style="float:left;">
            <label>Skype:</label>
            <input type="hidden" name="campo_skype" value="Skype" />
            <input name="skype" type="text" value="" style="width:115px;" />
          </div>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;"">
            <label>&iquest;Pose&eacute; cuenta bancaria?</label>
            <input type="hidden" name="campo_cuenta_bancaria" value="&iquest;Pose&eacute; cuenta bancaria?" />
            <input name="cuenta_bancaria" type="radio" value="si" />
            Si
            <input name="cuenta_bancaria" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>Tipo de cuenta:</label>
            <input type="hidden" name="campo_tipo_cuenta" value="Tipo de cuenta" />
            <input name="tipo_cuenta" type="text" value="" style="width:160px;" />
          </div>
          <div style="float:left;">
            <label>Banco:</label>
            <input type="hidden" name="campo_banco" value="Banco" />
            <input name="banco" type="text" value="" style="width:155px;" />
          </div>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;"">
            <label>&iquest;Tiene experiencia en mystery shopping?:</label>
            <input type="hidden" name="campo_experiencia" value="&iquest;Tiene experiencia en mystery shopping?" />
            <input name="experiencia" type="radio" value="si" />
            Si
            <input name="experiencia" type="radio" value="no" />
            No </div>
        </div>
        <div class="campo_form">
          <label><strong>*</strong> Comentario:</label>
        </div>
        <div>
          <input type="hidden" name="campo_mensaje" value="Mensaje" />
          <textarea name="mensaje" rows="5" class="required" style="width:520px;" cols="1"></textarea>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Posee automovil?:</label>
            <input type="hidden" name="campo_automovil" value="&iquest;Posee automovil?" />
            <input name="automovil" type="radio" value="si" />
            Si
            <input name="automovil" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>Modelo:</label>
            <input type="hidden" name="campo_modelo" value="Modelo" />
            <input name="modelo" type="text" value="" style="width:70px;" />
          </div>
          <div style="float:left; padding-right:20px;">
            <label>A&ntilde;o:</label>
            <input type="hidden" name="campo_anio_movil" value="A&ntilde;o" />
            <input name="anio_movil" type="text" value="" style="width:70px;" />
          </div>
          <div style="float:left;">
            <label>Tipo de combustible:</label>
            <input type="hidden" name="campo_combustible" value="Tipo de combustible" />
            <input name="combustible" type="radio" value="Diesel" />
            Diesel
            <input name="combustible" type="radio" value="GNC" />
            GNC
            <input name="combustible" type="radio" value="Nafta" />
            Nafta </div>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Posee carnet de conducir?:</label>
            <input type="hidden" name="campo_carnet" value="&iquest;Posee carnet de conducir?" />
            <input name="carnet" type="radio" value="si" />
            Si
            <input name="carnet" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Posee motocicleta?:</label>
            <input type="hidden" name="campo_moto" value="&iquest;Posee motocicleta?" />
            <input name="moto" type="radio" value="si" />
            Si
            <input name="moto" type="radio" value="no" />
            No </div>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Consume bebidas alcoholicas?:</label>
            <input type="hidden" name="campo_bebe_alcoholicas" value="&iquest;Consume bebidas alcoholicas?" />
            <input name="bebe_alcoholicas" type="radio" value="si" />
            Si
            <input name="bebe_alcoholicas" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Bebe cafe?:</label>
            <input type="hidden" name="campo_bebe_cafe" value="&iquest;Bebe cafe?" />
            <input name="bebe_cafe" type="radio" value="si" />
            Si
            <input name="bebe_cafe" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Esta dispuesto a viajar?:</label>
            <input type="hidden" name="campo_viajar" value="&iquest;Esta dispuesto a viajar?" />
            <input name="viajar" type="radio" value="si" />
            Si
            <input name="viajar" type="radio" value="no" />
            No </div>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Maneja otro idioma?:</label>
            <input type="hidden" name="campo_idioma" value="&iquest;Maneja otro idioma?" />
            <input name="idioma" type="radio" value="si" />
            Si
            <input name="idioma" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>Cual/es:</label>
            <input type="hidden" name="campo_cual" value="Cual/es" />
            <input name="cual" type="text" class="required" value="" style="width:150px;" />
          </div>
          <div style="float:left;">
            <label>Nivel:</label>
            <input type="hidden" name="campo_nivel" value="Nivel:" />
            <input name="nivel" type="text" class="required" value="" style="width:150px;" />
          </div>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Tiene tarjeta de credito?:</label>
            <input type="hidden" name="campo_tarjeta" value="&iquest;Tiene tarjeta de credito?" />
            <input name="tarjeta" type="radio" value="si" />
            Si
            <input name="tarjeta" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Tiene hijos?:</label>
            <input type="hidden" name="campo_hijos" value="&iquest;Tiene hijos?" />
            <input name="hijos" type="radio" value="si" />
            Si
            <input name="hijos" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Tiene mascotas?:</label>
            <input type="hidden" name="campo_mascotas" value="&iquest;Tiene mascotas?" />
            <input name="mascotas" type="radio" value="si" />
            Si
            <input name="mascotas" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Usa lentes?:</label>
            <input type="hidden" name="campo_lentes" value="&iquest;Usa lentes?" />
            <input name="lentes" type="radio" value="si" />
            Si
            <input name="lentes" type="radio" value="no" />
            No </div>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Tiene facil acceso a internet?:</label>
            <input type="hidden" name="campo_internet" value="&iquest;Tiene facil acceso a internet?" />
            <input name="internet" type="radio" value="si" />
            Si
            <input name="internet" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Tiene scanner?:</label>
            <input type="hidden" name="campo_scanner" value="&iquest;Tiene scanner?" />
            <input name="scanner" type="radio" value="si" />
            Si
            <input name="scanner" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px;">
            <label>&iquest;Tiene impresora?:</label>
            <input type="hidden" name="campo_impresora" value="&iquest;Tiene impresora?" />
            <input name="impresora" type="radio" value="si" />
            Si
            <input name="impresora" type="radio" value="no" />
            No </div>
          <div style="float:left; padding-right:20px; padding-top:20px;">
            <label>&iquest;Tiene camara digital o celular con camara?:</label>
            <input type="hidden" name="campo_camara" value="&iquest;Tiene camara digital o celular con camara?" />
            <input name="camara" type="radio" value="si" />
            Si
            <input name="camara" type="radio" value="no" />
            No </div>
        </div>
        <div class="separador"><span></span></div>
        <div class="campo_form">
          <div style="float:left; padding-right:20px;">
            <label>Cargar CV:</label>
            <input name="" type="file" />
          </div>
          <div style="float:left; padding-right:20px;">
            <label>Cargar foto:</label>
            <input name="" type="file" />
          </div>
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
<script>
$("#cmb_prov").change(function(){
	$.get("localidades.json.php", {pid: $(this).val()}, function (data) {
		$("#cmb_loc option").remove();
		$("#cmb_loc").append($("<option></option>").attr("value","0").text("--seleccione--"));
		
		$.each(data, function (key, obj) {
			$("#cmb_loc").append($("<option></option>").attr("value",obj.nombre).text(obj.nombre));
		});
		
	}, "json");
}); 

function load_localidades(prov_id){
	
}
</script>