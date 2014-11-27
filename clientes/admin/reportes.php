<script type="text/javascript" src="js_library/highcharts/highcharts.js"></script>
<script type="text/javascript" src="js_library/highcharts/modules/exporting.js"></script>

<div id="page_tittle">
  <div id="ico"><img src="images/ico_reportes-trans.png" width="49" height="50" alt="" /></div>
  <h1>Reportes</h1>
</div>
<div id="conteniner_tabs">
  <ul class="tabs">
    <li><a href="#tab_0">Variables Generales</a></li>
    <li><a href="#tab_1">Ventas</a></li>
    <li><a href="#tab_2">Relaci&oacute;n venta - atenci&oacute;n</a></li>
    <li><a href="#tab_3">Todas las variables</a></li>
  </ul>
</div>
<div class="block">
  <div id="tab_0" class="tab_content">
    <?php include("reporte_tab_variables_generales.inc.php"); ?>
  </div>
  <div id="tab_1" class="tab_content">
    <?php include("reportes_tab_ventas.inc.php"); ?>
  </div>
  <div id="tab_2" class="tab_content">
    <?php include("reportes_tab_relacion_venta_atencion.inc.php"); ?>
  </div>
  <div id="tab_3" class="tab_content">
    <?php include("reportes_tab_todas_variables.inc.php"); ?>
  </div>
</div>
