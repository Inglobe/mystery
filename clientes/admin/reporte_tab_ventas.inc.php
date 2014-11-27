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
    <h3 class="title_color">Ventas:</h3>
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
		$db_total = new database;
		$db_total->query("SELECT SUM(p.monto_compra) AS total FROM proyectos p WHERE id_cliente = ".$client_data["id_cliente"]);
		$db_total->fetch();
		$total = $db_total->getValue("total");
		
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
			$total_suc = ventasBySucursal($db_report_child->getValue("id_sucursal"));
			
			/*echo "Total suc: ".$total_suc."<br />";
			echo "Total: ".$total;*/
			
			$porc = number_format($total_suc * 100 / $total,1);
			
			echo $porc;
			
			$datos[] = $porc;
  		  ?>%</td>
        </tr>
    <?
		}
	?>
      </tbody>
    </table>
  </div>
  <div id="container_chart_b1" style="width: 876px; height: 400px;"></div>
  <script type="text/javascript">
		/*grafico barras*/
		var chart_b1;
		chart_b1 = new Highcharts.Chart({
			chart: {
				renderTo: 'container_chart_b1',
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
