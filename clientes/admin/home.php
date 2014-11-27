<?php include("col-izq.inc.php"); ?>
<div id="page_tittle">
  <h1 id="tit_home">&iexcl;Bienvenido al Adminstrador!</h1>
  <div id="logo_client"><img src="image.php?ruta=../../sistema/imagenes/clientes/logos/<?=$db_load->getXHTMLValue("logo_cliente")?>&amp;ancho=80&amp;alto=60&amp;mantener_ratio=1&amp;franjas=1" width="80" height="60" alt="" /></div>
  <div id="contact_data"><strong><?=$db_load->getXHTMLValue("nombre")?></strong><br />
    <?=$db_load->getXHTMLValue("domicilio")?> <br />
    <a href="mailto:<?=$db_load->getXHTMLValue("email")?>"><?=$db_load->getXHTMLValue("email")?></a></div>
</div>
<div id="content_home">
  <div class="subtit title_color">
    <h4>Accesos directos</h4>
  </div>
  <div class="comando_home">
    <div class="box_comando_home gradient_normal"><a href="index.php?put=auditorias_search"><img height="88" width="85" alt="" src="images/ico_auditorias-trans.png"></a> </div>
    <div class="tit">
      <h3><a href="index.php?put=auditorias_search">Ver<br />
<strong class="title_color">AUDITORIAS</strong></a></h3>
    </div>
    <div class="txt">Visualice&nbsp;todos los informes, videos y fotografias de cada una de sus sucursales</div>
    <div class="btn"><a href="index.php?put=auditorias_search" class="title_color">ingresar ></a></div>
  </div>
  <div class="comando_home">
    <div class="box_comando_home gradient_normal"><a href="index.php?put=reporte_tab_variables_generales"><img height="78" width="93" alt="" src="images/ico_reportes-trans.png"></a> </div>
    <div class="tit">
      <h3><a href="index.php?put=reporte_tab_variables_generales">Ver<br />
<strong class="title_color">REPORTES</strong></a></h3>
    </div>
    <div class="txt">Analice los puntajes obtenidos en cada una de las auditorias a traves de&nbsp;gr&aacute;ficos&nbsp;interactivos</div>
    <div class="btn"><a href="index.php?put=reporte_tab_variables_generales" class="title_color">ingresar ></a></div>
  </div>
  <div class="comando_home">
    <div class="box_comando_home gradient_normal"><a href="index.php?put=support"><img height="95" width="89" alt="" src="images/ico_soporte-trans.png"></a> </div>
    <div class="tit">
      <h3><a href="index.php?put=support">Solicit&aacute;<br />
<strong class="title_color">SOPORTE</strong></a></h3>
    </div>
    <div class="txt">Env&iacute;e&nbsp;sus consultas y solicite nuevas auditorias utilizando este medio</div>
    <div class="btn"><a href="index.php?put=support" class="title_color">ingresar ></a></div>
  </div>
  <div class="comando_home">
    <div class="box_comando_home gradient_normal"><a href="index.php?put=help"><img height="93" width="92" alt="" src="images/ico_ayuda-trans.png"></a> </div>
    <div class="tit">
      <h3><a href="index.php?put=help">Ver<br />
<strong class="title_color">AYUDA</strong></a></h3>
    </div>
    <div class="txt">Un completo tutorial con toda la informacion acerca del sistema</div>
    <div class="btn"><a href="index.php?put=help" class="title_color">ingresar ></a></div>
  </div>
  <script>
	$(function() {
		var dates = $( "#from, #to" ).datepicker({
			defaultDate: "+1w",
			onSelect: function( selectedDate ) {
				var option = this.id == "from" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});
	</script><? /*
  <div id="home_filters">
    <form>
      <div class="input">
        <input type="text" id="from" name="from"/>
      </div>
      <div class="input">
        <input type="text" id="to" name="to"/>
      </div>
    </form>
  </div>
  <div id="paginacion">
    <div id="page_number_of"><strong>Pagina 7</strong> de 367:</div>
    <div id="btn_first_page"><a href="#">&lt;&lt;</a></div>
    <div id="btn_previous_page"><a href="#">&lt;&lt; anterior</a></div>
    <div id="numbers">
      <div class="number"><a href="#">1</a></div>
      <div class="number"><a href="#">2</a></div>
      <div class="number"><a href="#">3</a></div>
      <div class="number active"><a href="#">4</a></div>
      <div class="number"><a href="#">5</a></div>
      <div class="number"><a href="#">6</a></div>
      <div class="number"><a href="#">7</a></div>
    </div>
    <div id="btn_next_page"><a href="#">siguiente &gt;&gt;</a></div>
    <div id="btn_last_page"><a href="#">&gt;&gt;</a></div>
  </div> */ ?>
</div>
