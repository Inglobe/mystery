<?
if($consulta != ""){
	$result_nro = mysql_query($consulta,$link);
	$reg_nro = 0;
	$mostrar_puntos_izq = true;
	while($fila = mysql_fetch_array($result_nro)){
		$reg_nro ++;
	}
	$ventana=7;
	$pag_nro = ceil($reg_nro/$paginacion);
	$pag_actual = ($ls+$paginacion)/$paginacion;
	$ultima_pag_ls = $reg_nro-$paginacion;
	if($pag_actual > floor($ventana/2)){
		$ventana_li = $pag_actual - floor($ventana/2);
	}
	else{
		$ventana_li = 1;
	}

	foreach($_GET as $param_clave => $param_valor){
		if($param_clave != "ls" && $param_clave != "put"){
			$parametros .= "&amp;".$param_clave."=".$param_valor;
		}
	}
	foreach($_POST as $param_clave => $param_valor){
		$parametros .= "&amp;".$param_clave."=".$param_valor;
	}
?>


  <div id="paginador">
<?
if($reg_nro > 0){
?>
    <div id="pagina_actual">Page <?=floor($pag_actual)?>/<?=$pag_nro?></div>
<?
}
?>
    <div id="controles_paginador">
<?
	$ventana_ls = $ventana_li + $ventana;
	if($ls != 0){
		$atras = $ls - $paginacion;
	?>
		<a href="<?="index.php?put=".$put."&amp;ls=0".$parametros?>"><img src="imagenes/paginador/btn_pag_primero.gif" alt="" border="0" align="left" /></a><a href="<?="index.php?put=".$put."&amp;ls=".$atras.$parametros?>"><img src="imagenes/paginador/btn_pag_anterior.gif" alt="" border="0" align="left" /></a>
	<?
	}
	else{
	?>
		<img src="imagenes/paginador/btn_pag_primero_off.gif" alt="" border="0" align="left" /><img src="imagenes/paginador/btn_pag_anterior_off.gif" alt="" border="0" align="left" />
	<?
	}
	if($reg_nro > 0){
	?>

			<div id="esquina_izq"><span></span></div>
			<div id="ir_pagina">

		<?
		for($pag = 1;$pag <= $pag_nro;$pag ++){
			if($mostrar_puntos_izq && $pag_actual > ceil($ventana/2)){
				$mostrar_puntos_izq = false;
	?>
						<div class="puntos">...</div>
	<?
			}
			if($pag >= $ventana_li && $pag < $ventana_ls){//VENTANA
				$reg_desde = ($pag * $paginacion) - $paginacion;
				if($pag == $pag_actual){ //PAGINA ACTUAL
	?>					<div class="numeros">
						<?
						$array_numeros = str_split($pag);
						foreach($array_numeros as $numero){
							?><img src="imagenes/paginador/num_bold_<?=$numero?>.gif" border="0" /><?
						}
						if($pag != $pag_nro){
						?><img src="imagenes/paginador/palito.gif" alt="" /><?
						}
						?></div>
	<?
				}
				else{
	?>
						<div class="numeros"><a href="<?="index.php?put=".$put."&amp;ls=".$reg_desde.$parametros?>"><?
						$array_numeros = str_split($pag);
						foreach($array_numeros as $numero){
							?><img src="imagenes/paginador/num_<?=$numero?>.gif" border="0" /><?
						}
						?></a><?
						if($pag != $pag_nro){
						?><img src="imagenes/paginador/palito.gif" alt="" /><?
						}
						?></div>
	<?
				}
			}
		}
		if($pag_actual <= ($pag_nro - ceil($ventana/2))){
	?>
						<div class="puntos">...</div>
	<?
		}
	?>
			</div>
			<div id="esquina_der"><span></span></div>
	<?
	}
	if($pag_nro > 1 && ($ls + $paginacion) < ($pag_nro * $paginacion)){
		$adelante = $ls + $paginacion;
	?>
		<a href="<?="index.php?put=".$put."&amp;ls=".$adelante.$parametros?>"><img src="imagenes/paginador/btn_pag_siguiente.gif" alt="" border="0" align="left" /></a><a href="<?="index.php?put=".$put."&amp;ls=".$ultima_pag_ls.$parametros?>"><img src="imagenes/paginador/btn_pag_ultimo.gif" alt="" border="0" align="left" /></a>
	<?
	}
	else{
	?>
		<img src="imagenes/paginador/btn_pag_siguiente_off.gif" alt="" border="0" align="left" /><img src="imagenes/paginador/btn_pag_ultimo_off.gif" alt="" border="0" align="left" />
	<?
	}
	?>
    </div>
  </div>
<?
}
?>