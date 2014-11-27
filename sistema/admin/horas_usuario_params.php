<div id="titulo">
    <h1><span>Reportes</span><span class="separador_tit">/</span><span class="gris">Horas por usuario</span></h1>
  </div>
  <div id="filtros">
    <div class="cbza_bloque">
      <div class="cont_fondo_bloque_sup_izq">
        <div class="fondo_bloque_sup_izq"><span></span></div>
      </div>
      <div class="cont_fondo_bloque_sup_der">
        <div class="fondo_bloque_sup_der"><span></span></div>
      </div>
    </div>
    <div class="borde_bloque_izq">
      <div class="borde_bloque_der">
        <div class="cuerpo_bloque">
          <form name="agenda_form" id="agenda_form" method="get" action="index.php">
            <input type="hidden" value="agenda" id="put" name="put">
            <fieldset>
              <legend>Filtros</legend>
              <div class="campo">
            <label for="filtro_fecha_from" style="float:left; margin-top:4px; margin-right:4px;">Desde:</label>
            <script type="text/javascript">
				// <![CDATA[
								  FSfncWriteFieldHTML("agenda_form","filtro_fecha_from","24/6/2011","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			</script>
          </div>
          <div class="campo">
            <label for="filtro_fecha_to" style="float:left; margin-top:4px; margin-right:4px;">Hasta:</label>
            <script type="text/javascript">
				// <![CDATA[
								  FSfncWriteFieldHTML("agenda_form","filtro_fecha_to","24/6/2011","","clases/ABMControls/datePicker/images/FSdateSelector/","en",true,true);
				// ]]>
			  	</script>
          </div>
              <div class="campo">
                <label for="filtro_id_cliente">Tipo de tarea:</label>
                <select style="width:225px;" id="filtro_id_usuario_responsable" name="filtro_id_usuario_responsable">
                  <option value="">--todos--</option>
                  <option value="4">Cristian Jimenez</option>
                  <option value="3">Emilio Elias</option>
                  <option selected="selected" value="6">Facundo Cargnelutti</option>
                  <option value="5">Federico Molfino</option>
                  <option value="2">Lorena Boasi</option>
                  <option value="1">Mauro Moreno</option>
                  <option value="7">Sergio Sixto Medina</option>
                </select>
              </div>
              <div class="campo">
                <label for="filtro_id_usuario_supervisor">Usuario:</label>
                <select style="width:225px;" id="filtro_id_usuario_supervisor" name="filtro_id_usuario_supervisor">
                  <option value="">--todos--</option>
                  <option value="4">Cristian Jimenez</option>
                  <option value="3">Emilio Elias</option>
                  <option value="6">Facundo Cargnelutti</option>
                  <option value="5">Federico Molfino</option>
                  <option value="2">Lorena Boasi</option>
                  <option value="1">Mauro Moreno</option>
                  <option value="7">Sergio Sixto Medina</option>
                </select>
              </div>
            </fieldset>
            <div id="btns_ok_cancel">
		  	<input type="image" hspace="4" border="0" alt="" value="1" id="print" name="print" src="imagenes/btn_print.jpg">
			<input type="image" hspace="4" border="0" alt="" value="1" id="download" name="download" src="imagenes/btn_download.jpg">
			<input type="image" hspace="4" border="0" alt="" value="1" id="chart" name="chart" src="imagenes/btn_chart.jpg">
		  </div>
          </form>
        </div>
      </div>
    </div>
    <div class="pie_bloque">
      <div class="cont_fondo_bloque_inf_izq">
        <div class="fondo_bloque_inf_izq"><span></span></div>
      </div>
      <div class="cont_fondo_bloque_inf_der">
        <div class="fondo_bloque_inf_der"><span></span></div>
      </div>
    </div>
  </div>
  <script src="js_library/reportes.js" type="text/javascript"></script>
