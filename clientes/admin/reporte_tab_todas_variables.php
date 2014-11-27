<?
	$db_tmp = new database;
	$db_tmp->query("SELECT cl.* FROM contactos con JOIN clientes cl ON con.id_cliente = cl.id_cliente WHERE con.id_contacto = ".$_SESSION["id_usr"]);
	$db_tmp->fetch();
	$client_data = $db_tmp->getValues();
?>
<script type="text/javascript" src="js_library/highcharts/highcharts.js"></script>
<script type="text/javascript" src="js_library/highcharts/modules/exporting.js"></script>
<link type="text/css" rel="stylesheet" media="print" href="css_library/print.css" />

<div id="page_tittle">
  <div id="ico"><img src="images/ico_reportes-trans.png" width="49" height="50" alt="" /></div>
  <h1>Reportes</h1>
</div>
<div id="conteniner_tabs">
  <ul class="tabs">
    <li><a href="index.php?put=reporte_tab_variables_generales">Variables Generales</a></li>
    <li><a href="index.php?put=reporte_tab_ventas">Ventas</a></li>
    <li><a href="index.php?put=reporte_tab_relacion_venta_atencion">Relación venta - atención</a></li>
    <li class="active"><a href="index.php?put=reporte_tab_todas_variables">Todas las variables</a></li>
  </ul>
</div>
<div class="block">
  <div class="separator">
    <h3 class="title_color">Filtro</h3>
    <span></span></div>
  <div style="clear:both; height:60px;">
    <form name="form_filtro" method="get">
	  <input type="hidden" name="put" value="reporte_tab_todas_variables" />
      <div class="input">
        <input name="from" type="text" id="from" value="desde"/>
      </div>
      <div class="input">
        <input type="text" id="to" name="to" value="hasta"/>
      </div>
	  <script type="text/javascript">
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
	  </script>
	  <div class="input">
        <select name="plid" id="" onchange="document.form_filtro.submit();">
		<?
		$db_plantillas = new database_format;
		$db_plantillas->query("SELECT * FROM proyectos WHERE plantilla = 1 AND id_cliente = ".$client_data["id_cliente"]." ORDER BY nombre ASC");
		while($db_plantillas->fetch()){
			$id_plantilla = $db_plantillas->getValue("id_proyecto");
		?>
		  <option value="<?=$id_plantilla?>" <?=($_GET["plid"]==$id_plantilla?'selected="selected"':'')?>><?=$db_plantillas->getXHTMLValue("nombre")?></option>
		<?
		}
		?>
		</select>
      </div>
    </form>
    <div style="position:absolute; padding:20px; right:0px;"><a href="javascript:window.print();"><img src="images/btn_imprimir_reporte.gif" width="116" height="21" alt="" /></a></div>
  </div>
  <?php include("reporte_tab_todas_variables.inc.php"); ?>
</div>