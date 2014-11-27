<?
	require("reportes_funciones.inc.php");
	if(empty($_GET["plid"])){
		$db_plantillas = new database;
		$db_plantillas->query("SELECT id_proyecto FROM proyectos WHERE plantilla = 1 AND id_cliente = ".$client_data["id_cliente"]." ORDER BY nombre ASC LIMIT 1");
		$db_plantillas->fetch();
		$_GET["plid"] = $db_plantillas->getValue("id_proyecto");
	}
	if(empty($_GET["plid"])){
		$db_tmp = new database;
		$db_tmp->query("SELECT id_proyecto FROM proyectos WHERE id_cliente = ".$client_data["id_cliente"]." ORDER BY id_proyecto DESC LIMIT 1");
		$db_tmp->fetch();
		$_GET["plid"] = $db_tmp->getValue("id_proyecto");
	}
?>
<div class="grafic_chart">
  <div class="separator gradient_theme">
    <h3 class="title_color">Variables Auditadas:</h3>
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
	function mostrar_tarea($id_cliente, $id_padre, $desc_padre = "", $id_proyecto, $nivel, $ruta="", $nro_hijos_principal = 0, &$puntaje=array()){
		global $_SESSION;
		global $total;
		
		$letras_array = array("A","B","C","D","E","F","G","H","I","J");

		$cadena="SELECT 
					*
				FROM 		
					tareas
				WHERE 		
					id_tarea_padre = ".$id_padre." AND
					id_proyecto = ".$id_proyecto." AND
					ocultar = 0
					
				ORDER BY	
					orden ASC
				";
				
		$db_tareas = new database_format;
		
		$db_tareas->query($cadena);
		
		if(empty($ruta)){
			$ruta=$nivel;
		}
		else{
			$ruta.=".";
		}

		$orden = 0;
		while ($db_tareas->fetch()) {
			$db_hijos = new database;
			$db_hijos->query("SELECT COUNT(*) AS nro FROM tareas WHERE id_tarea_padre = ".$db_tareas->getValue("id_tarea")." AND ocultar = 0");
			$db_hijos->fetch();
			$nro_hijos = $db_hijos->getValue("nro");
			$tiene_hijos = ($nro_hijos>0?true:false);
			
			$porc = porcTareaGralByDesc($db_tareas->getValue("descripcion"), $id_cliente, $desc_padre);
			
			if($nivel == 0){
				$nro_hijos_principal = $nro_hijos;
				$ruta = $letras_array[$orden];
				$ruta_mostrar = $ruta;
				$puntaje["puntaje"] = 0;
			}
			else{
				$ruta_mostrar = $ruta.($orden+1);
				$puntaje["puntaje"] += $porc;
			}
			
			if(!$tiene_hijos){
				$puntaje["titulos"][] = "'".$ruta_mostrar."'";
				$puntaje["datos_puntaje"][] = $porc;
				$puntaje["totales"][] = 0;
			}
		
		?>
		<tr class="light_row">
          <td><?=$ruta_mostrar." | ".$db_tareas->getXHTMLValue("descripcion")?></td>
          <td><?=($nivel>0?$porc."%":"")?> <?//=$nivel.":".($orden + 1).":".$nro_hijos_principal?></td>
        </tr>
		<?
			if($nro_hijos_principal == ($orden + 1) && $nivel > 0) {
				if(!isset($puntaje["puntaje_total"])){
					$puntaje["puntaje_total"] = 0;
				}
				if(!$tiene_hijos){
					$puntaje["titulos"][] = "'St.'";
					$puntaje["datos_puntaje"][] = 0;
					$puntaje["totales"][] = number_format($puntaje["puntaje"]/($orden + 1),1);
				}
				
				$puntaje["puntaje_total"]+= $puntaje["puntaje"];
		?>
		<tr class="dark_row">
          <td colspan="2" align="right"><div style="padding-right:5px;"><strong>Subtotal:</strong> <?=number_format($puntaje["puntaje"]/($orden + 1),1)?>%</div></td>
        </tr>
		<?
			}
		  
			mostrar_tarea($id_cliente, $db_tareas->getValue("id_tarea"), $db_tareas->getValue("descripcion"), $id_proyecto, $nivel+1, $ruta, $nro_hijos_principal, $puntaje);
			$orden++;
		}
	}
	//$puntaje = array("puntaje_total"=>0);
	mostrar_tarea($client_data["id_cliente"], 0, "", $_GET["plid"], 0, "", 0, $puntaje);
	$cantidad_st = 0;
	foreach($puntaje["totales"] as $subtotal){
		if($subtotal>0){
			$cantidad_st++;
			$total+= $subtotal;
		}
	}
	
	$total = number_format($total / $cantidad_st,1); 
	reset($puntaje["totales"]);
	//print_r($puntaje);
?>
      </tbody>
      <tfoot>
        <tr class="dark_row">
          <td align="right"><strong>Total (general)</strong></td>
          <td><?=number_format($total,1)?>%</td>
        </tr>
      </tfoot>
    </table>
  </div>
  <div style="width: 876px; height: 450px;overflow:auto;"><div id="container_chart_d2" style="width: 1500px; height: 400px;"></div></div>
  <script type="text/javascript">
		/*grafico barras*/
		var chartd2;
		chartd2 = new Highcharts.Chart({
			chart: {
				renderTo: 'container_chart_d2',
				defaultSeriesType: 'column',
				backgroundColor: '#F4F4F4'
			},
			title: {
				text: 'Variables Auditadas'
			},
			xAxis: {
				categories: [<?=implode(",",$puntaje["titulos"])?>,'Total']
			},
			yAxis: {
				min: 0,
				max: 100,
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
						name: 'Puntaje',
						data: [<?=implode(",\n",$puntaje["datos_puntaje"])?>,0]
					}, {
						name: 'Subtotal',
						data: [<?=implode(",\n",$puntaje["totales"])?>,<?=$total?>]
					}]
		});
	</script> 
</div>
<? /*
<div class="grafic_chart">
  <div class="separator gradient_theme">
    <h3 class="title_color">&iquest;Volverias a comprar en esta sucursal?:</h3>
  </div>
  <div id="grafics_data">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <thead>
        <tr>
          <th>Pregunta</th>
          <th>Porc.</th>
        </tr>
      </thead>
      <tbody>
        <tr class="light_row">
          <td>Si</td>
          <td>80.00%</td>
        </tr>
        <tr class="dark_row">
          <td>No</td>
          <td>20.00%</td>
        </tr>
    </table>
  </div>
  <div id="container_chart_d1" style="width: 876px; height: 400px;"></div>
  <script type="text/javascript">
		var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container_chart_d1',
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
				backgroundColor: '#F4F4F4'
            },
            title: {
                text: '¿Volverias a comprar en esta sucursal?'
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        color: '#000000',
                        connectorColor: '#000000',
                        formatter: function() {
                            return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
                        }
                    }
                }
            },
            series: [{
                type: 'pie',
                name: 'Respuesta - Porcentaje',
                data: [
                    ['Si',80],
                    ['No',20]
                ]
            }]
        });
    });
	</script> 
</div> */ ?>