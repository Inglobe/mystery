<?
	require("reportes_funciones.inc.php");
	if(empty($_GET["plid"])){
		$db_plantillas = new database;
		$db_plantillas->query("SELECT id_proyecto FROM proyectos WHERE plantilla = 1 AND id_cliente = ".$client_data["id_cliente"]." ORDER BY nombre ASC LIMIT 1");
		$db_plantillas->fetch();
		$_GET["plid"] = $db_plantillas->getValue("id_proyecto");
	}
	
?>
<div class="grafic_chart">
  <div class="separator gradient_theme">
    <h3 class="title_color">Variables generales: (<?
	$db_tmp = new database;
	$db_tmp->query("SELECT COUNT(*) AS nro FROM sucursales WHERE id_cliente = ".$client_data["id_cliente"]);
	$db_tmp->fetch();
	echo $db_tmp->getValue("nro");
?>	sucursales)</h3>
  </div>
  <div id="grafics_data">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th>Descripci&oacute;n</th>
          <th>valor</th>
        </tr>
      </thead>
      <tbody>
	<?
	$db_report = new database_format;
	$sql = "
		SELECT 
			t.id_tarea,
			t.descripcion,
			p.id_cliente
		FROM
			tareas t
			JOIN proyectos p ON t.id_proyecto = p.id_proyecto
		WHERE
			t.id_tarea_padre = 0 AND
			t.ocultar = 0 AND
			p.id_cliente = ".$client_data["id_cliente"]." AND
			p.id_estado_proyecto = 3 
		GROUP BY
			t.descripcion
	";

	$db_report->query($sql);
	$color = "dark_row";
	$titulos = array();
	$datos = array();
	while($db_report->fetch()){
		$color = ($color=="light_row"?"dark_row":"light_row");
	?>
        <tr class="<?=$color?>">
          <td><?
			echo $db_report->getXHTMLValue("descripcion");
			$titulo = $db_report->getValue("descripcion");
			$titulos[] = "'".$titulo."'";
			?></td>
          <td><? 
			$porc = porcRamaGralByDesc($titulo,$db_report->getValue("id_cliente"));
			echo $porc;
			$datos[] = number_format($porc,1);
  		  ?>%</td>
        </tr>
    <?
	}
	?>
      </tbody>
    </table>
  </div>
  <div id="container_chart" style="width: 876px; height: 400px;"></div>
  <script type="text/javascript">
		/*grafico barras*/
		var chart;
		chart = new Highcharts.Chart({
			chart: {
				renderTo: 'container_chart',
				defaultSeriesType: 'column',
				backgroundColor: '#F4F4F4'
			},
			title: {
				text: 'Variables generales'
			},
			xAxis: {
				categories: [<?=implode(",",$titulos)?>]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Porcentaje'
				}
			},
			tooltip: {
				formatter: function() {
					return ''+
						this.x +': '+ this.y +' %';
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
				series: [{
				name: 'Variables generales',
				data: [<?=implode(",",$datos)?>]

			}]
		});
	</script> 
</div>
<?
$db_report = new database_format;
$sql = "
	SELECT 
		t.id_tarea,
		t.descripcion,
		p.id_cliente
	FROM
		tareas t
		JOIN proyectos p ON t.id_proyecto = p.id_proyecto
	WHERE
		t.id_tarea_padre = 0 AND
		t.ocultar = 0 AND
		p.id_cliente = ".$client_data["id_cliente"]." AND
		p.id_estado_proyecto = 3 AND
		p.id_plantilla_base = ".(int)$_GET["plid"]."
	GROUP BY
		t.descripcion
";

$db_report->query($sql);
while($db_report->fetch()){
	$id_tarea = $db_report->getValue("id_tarea");
?>
<div class="grafic_chart">
  <div class="separator gradient_theme">
    <h3 class="title_color"><?=$db_report->getXHTMLValue("descripcion")?></h3>
  </div>
  <div id="grafics_data">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th>Sucursal</th>
          <th>valor</th>
        </tr>
      </thead>
      <tbody>
	<?
		$db_report_child = new database_format;
		$sql = "
			SELECT 
				s.id_sucursal,
				s.nombre
			FROM
				sucursales s
			WHERE
				s.id_cliente = ".$db_report->getXHTMLValue("id_cliente")." 
			ORDER BY
				s.nombre
		";
		$db_report_child->query($sql);
		$color = "dark_row";
		$titulos = array();
		$datos = array();
		$indice = 0;
		while($db_report_child->fetch()){
			$indice++;
			$color = ($color=="light_row"?"dark_row":"light_row");
	?>
        <tr class="light_row">
          <td><?
			echo "V".$indice.": ".$db_report_child->getXHTMLValue("nombre");
			$titulo = "V".$indice;
			$titulos[] = "'".$titulo."'";
			?></td>
          <td><? 
			$porc = porcTotalBySucursal($db_report_child->getValue("id_sucursal"), $db_report->getValue("descripcion"));
			echo number_format($porc,1);
			$datos[] = number_format($porc,1);
  		  ?>%</td>
        </tr>
    <?
		}
	?>
      </tbody>
      <tfoot>
        <tr class="dark_row">
          <td align="right"><strong>Total (general)</strong></td>
          <td><?=porcRamaGralByDesc($db_report->getValue("descripcion"),$db_report->getValue("id_cliente"))?>%</td>
        </tr>
      </tfoot>
    </table>
  </div>
  <div id="container_chart_<?=$id_tarea?>" style="width: 876px; height: 400px;"></div>
  <script type="text/javascript">
		/*grafico barras*/
		var chart_<?=$id_tarea?>;
		chart<?=$id_tarea?> = new Highcharts.Chart({
			chart: {
				renderTo: 'container_chart_<?=$id_tarea?>',
				defaultSeriesType: 'column',
				backgroundColor: '#F4F4F4'
			},
			title: {
				text: '<?=$db_report->getValue("descripcion")?>'
			},
			xAxis: {
				categories: [<?=implode(",",$titulos)?>]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Puntaje'
				}
			},
			tooltip: {
				formatter: function() {
					return ''+
						this.x +': '+ this.y +' %';
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
				series: [{
				name: 'Variables',
				data: [<?=implode(",",$datos)?>]

			}]
		});
	</script> 
</div>
<?
}
?>
<div class="grafic_chart">
  <div class="separator gradient_theme">
    <h3 class="title_color">Resultado total - Auditoria:</h3>
  </div>
  <div id="grafics_data">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th>Sucursal</th>
          <th>valor</th>
        </tr>
      </thead>
      <tbody>
    <?
		$db_report_child = new database_format;
		$sql = "
			SELECT 
				s.id_sucursal,
				s.nombre
			FROM
				sucursales s
			WHERE
				s.id_cliente = ".$client_data["id_cliente"]." 
			ORDER BY
				s.nombre
		";
		$db_report_child->query($sql);
		$color = "dark_row";
		$titulos = array();
		$datos = array();
		$indice = 0;
		while($db_report_child->fetch()){
			$indice++;
			$color = ($color=="light_row"?"dark_row":"light_row");
	?>
	  
        <tr class="light_row">
          <td><?
			echo "V".$indice.": ".$db_report_child->getXHTMLValue("nombre");
			$titulo = "V".$indice;
			$titulos[] = "'".$titulo."'";
			?></td>
          <td><? 
			$porc = porcTotalBySucursal($db_report_child->getValue("id_sucursal"));
			echo number_format($porc,1);
			$datos[] = number_format($porc,1);
  		  ?>%</td>
        </tr>
    <?
		}
	?>
      </tbody>
    </table>
  </div>
  <div id="container_chart7" style="width: 876px; height: 400px;"></div>
  <script type="text/javascript">
		/*grafico barras*/
		var chart7;
		chart7 = new Highcharts.Chart({
			chart: {
				renderTo: 'container_chart7',
				defaultSeriesType: 'column',
				backgroundColor: '#F4F4F4'
			},
			title: {
				text: 'Resultado total - Auditoria'
			},
			xAxis: {
				categories: [<?=implode(",",$titulos)?>]
			},
			yAxis: {
				min: 0,
				title: {
					text: 'Título del eje'
				}
			},
			tooltip: {
				formatter: function() {
					return ''+
						this.x +': '+ this.y +' %';
				}
			},
			plotOptions: {
				column: {
					pointPadding: 0.2,
					borderWidth: 0
				}
			},
				series: [{
				name: 'Resultado total - Auditoria',
				data: [<?=implode(",",$datos)?>]

			}]
		});
	</script> 
</div>
