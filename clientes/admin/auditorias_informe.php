<?
$id_load = $data->get("id",DATA_EX_TYPE_INT);

$db_load = new database_format;

$sql = "SELECT 
			p.*,
			DATE_FORMAT(dia_compra, '%d/%m/%Y') AS dia_compra_f,
			c.nombre AS cliente,
			c.logo AS logo_cliente,
			s.nombre AS sucursal,
			s.direccion AS sucursal_direccion
		FROM 
			proyectos p
			JOIN sucursales s ON s.id_sucursal = p.id_sucursal
			JOIN clientes c ON c.id_cliente = p.id_cliente
		WHERE 
			p.id_proyecto = ".$id_load."
		";
		
$db_load->query($sql);

$db_load->fetch();

$total = 0;

function tiene_hijos($id_tarea){
	$db = new database;
	$db->query("SELECT COUNT(*) AS nro FROM tareas WHERE id_tarea_padre = ".$id_tarea);
	$db->fetch();
	$nro = $db->getValue("nro");
	
	if($nro>0){
		return true;
	}
	else {
		return false;
	}
}
?>
<div id="page_tittle">
  <div id="ico"><img src="images/ico_auditorias_tit-trans.png" width="48" height="50" alt="" /></div>
  <h1><?=$db_load->getXHTMLValue("nombre")?></h1>
</div>
<div class="block">
  <div id="proyect_logo"><img src="image.php?ruta=../../sistema/imagenes/clientes/logos/<?=$db_load->getXHTMLValue("logo_cliente")?>&amp;ancho=160&amp;alto=130&amp;mantener_ratio=1&amp;franjas=1" width="160" height="130" alt="" /></div>
  <div id="col_data">
    <div class="col_data" style="width:170px;">
      <div class="dataflied">
        <div class="title">Sucursal:</div>
        <div class="data"><?=$db_load->getXHTMLValue("sucursal")?></div>
      </div>
      <div class="dataflied">
        <div class="title">Direcci&oacute;n:</div>
        <div class="data"><?=$db_load->getXHTMLValue("sucursal_direccion")?></div>
      </div>
      <div class="separator"><span></span></div>
      <div class="dataflied">
        <div class="title">D&iacute;a de compra:</div>
        <div class="data"><?=$db_load->getXHTMLValue("dia_compra_f")?></div>
      </div>
      <div class="dataflied">
        <div class="title">Monto de la compra:</div>
        <div class="data"><?=$db_load->getXHTMLValue("monto_compra")?></div>
      </div>
    </div>
    <div class="col_data" style="width:210px;">
      <div class="dataflied">
        <div class="title">Horario de entrada:</div>
        <div class="data"><?=$db_load->getXHTMLValue("hora_entrada")?></div>
      </div>
      <div class="dataflied">
        <div class="title">Horario de salida:</div>
        <div class="data"><?=$db_load->getXHTMLValue("hora_salida")?></div>
      </div>
      <div class="dataflied">
        <div class="title">Numero de clientes en el local:</div>
        <div class="data"><?=$db_load->getXHTMLValue("nro_clientes")?></div>
      </div>
      <div class="dataflied">
        <div class="title">Numero de empleados en el local:</div>
        <div class="data"><?=$db_load->getXHTMLValue("nro_empleados")?></div>
      </div>
	  <div class="dataflied">
        <div class="title">Vendedor:</div>
        <div class="data"><?=$db_load->getXHTMLValue("vendedor")?></div>
      </div>
    </div>
    <div class="col_data">
      <div class="dataflied">
        <div class="title">Puntaje Anterior:</div>
	<?
	$db_pgral = new database;
	$sql = "
			SELECT 
				(
					SELECT 
						SUM(t.tiempo) AS total 
					FROM 
						tareas t 
					WHERE
						t.id_proyecto = p.id_proyecto AND
						t.ocultar = 0
					GROUP BY
						t.id_proyecto
				) AS total_ant
			FROM 
				proyectos p
			WHERE
				p.id_cliente = ".$db_load->getValue("id_cliente")." AND
				p.id_estado_proyecto = 3 AND
				p.plantilla = 0 AND
				p.id_sucursal = ".$db_load->getValue("id_sucursal")." AND
				p.id_proyecto < '".$db_load->getValue("id_proyecto")."'
			ORDER BY 
				p.id_proyecto DESC
			";
	$db_pgral->query($sql);
	$db_pgral->fetch();
	?>
        <div class="data"><?=number_format($db_pgral->getValue("total_ant"),1)?></div>
      </div>
    </div>
	<?
	$db_pgral = new database;
	$sql = "
			SELECT 
				SUM(t.tiempo) AS total 
			FROM 
				tareas t 
			WHERE
				t.id_proyecto = ".$db_load->getValue("id_proyecto")." AND
				t.ocultar = 0
			GROUP BY
				t.id_proyecto
			";
	$db_pgral->query($sql);
	$db_pgral->fetch();
	?>
    <div id="puntaje_auditoria" class="gradient_theme">Puntaje: <span class="positive_color"><?=number_format($db_pgral->getValue("total"),1)?></span></div>
  </div>
</div>
<?
	
		function mostrar_tarea($id_padre, $id_proyecto, $nivel, $nro_hijos_principal = 0, &$puntaje = array()){
			global $_SESSION;
			global $total;

			$cadena="SELECT 		*,
									DATE_FORMAT(fecha_inicio_estimada,'%d/%m/%y') AS fecha_f,
									DATE_FORMAT(fecha_fin_estimada,'%d/%m/%y') AS fecha_f_f
						FROM 		tareas
						WHERE 		id_tarea_padre = ".$id_padre."
						AND 		id_proyecto = ".$id_proyecto."
						ORDER BY	orden
					";
			$db_tareas = new database_format;
			
			$db_tareas->query($cadena);

			$orden = 0;
			while ($db_tareas->fetch()) {
				$db_hijos = new database;
				$db_hijos->query("SELECT COUNT(*) AS nro FROM tareas WHERE id_tarea_padre = ".$db_tareas->getValue("id_tarea"));
				$db_hijos->fetch();
				$nro_hijos = $db_hijos->getValue("nro");
				$tiene_hijos = ($nro_hijos>0?true:false);
				
				if($nivel == 0){
					$nro_hijos_principal = $nro_hijos;
				}
		?>
        <div class="tarea_<?=$nivel?>" id="tarea_<?=$db_tareas->getValue("id_tarea")?>" <?=$db_tareas->getValue("ocultar")==1?'style="display:none"':''?>>
          <?
				require("tarea.inc.php");
				mostrar_tarea($db_tareas->getValue("id_tarea"), $id_proyecto, $nivel+1, $nro_hijos_principal, $puntaje);
		?>
        </div>
        <?
				$orden++;
			}
		}

		$db = new database;
		$db->query("SELECT COUNT(*) AS nro FROM tareas WHERE id_proyecto = ".$id_load." AND id_tarea_padre = 0 ORDER BY orden ASC");
		$db->fetch();
		$nro = $db->getValue("nro");

		if($nro>0){
			mostrar_tarea(0, $id_load, 0);
		}
	?>
<div class="block" style="height:50px;">
<div id="puntaje_auditoria" class="gradient_theme">Total: <span class="positive_color"><?=number_format($total,1)?></span></div>
</div>
<div class="block">
  <div class="separator">
    <h3 class="title_color">Videos</h3>
    <span></span></div>
  <script type='text/javascript' src='js_library/jwplayer/jwplayer.js'></script> 
  <script type='text/javascript' src='js_library/swfobject_1.5.js'></script>
<?
	$db_videos = new database_format;
	$db_videos->query("SELECT * FROM tareas WHERE id_proyecto = ".$id_load." AND obs LIKE '%youtube.com%'");
	while($db_videos->fetch()){
		if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $db_videos->getValue("obs"), $match)) {
			$video_id = $match[1];
		}
		$url_video = "http://www.youtube.com/watch/v/".$video_id;
?>
  <div id='mediaplayer_'></div>
  <script type="text/javascript">
    var so = new SWFObject('js_library/jwplayer/player.swf','playerID','888','500','9');
    so.addParam('wmode','opaque');
	so.addParam('allowfullscreen','true');
    so.addParam('allowscriptaccess','never');
    so.addVariable('file', '<?=$url_video?>');
    so.addVariable('skin', 'js_library/jwplayer/skins/glow.zip');
    so.addVariable('controlbar', 'bottom');
    so.write('mediaplayer_');
<?
	}
?>
</script>
  <div class="separator">
    <h3 class="title_color">Galer&iacute;a</h3>
    <span></span></div>
  <div id="photo_galery">
<?
	$db_fotos = new database_format;
	$db_fotos->query("SELECT at.* FROM archivos_tarea at JOIN tareas t ON at.id_tarea = t.id_tarea WHERE t.id_proyecto = ".$id_load." AND archivo LIKE '%.jpg'");
	while($db_fotos->fetch()){
?>
    <a href="../../sistema/downloads/tareas/<?=$db_fotos->getURLValue("archivo")?>" rel="grupo_fotos"><img src="image.php?ruta=../../sistema/downloads/tareas/<?=$db_fotos->getURLValue("archivo")?>&amp;ancho=100&amp;alto=67&amp;mantener_ratio=1" width="100" height="67" alt="" /></a> 
<?
	}
?>
</div>
  <div id="cont_btns_ok_cancel">
    <div id="btns_ok_cancel">
      <div class="button gradient_theme"><a href="javascript:history.back();">Volver</a></div>
    </div>
  </div>
</div>
