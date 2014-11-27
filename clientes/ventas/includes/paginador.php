				<ul class="paginador">

<?
	$result_nro = mysql_query($consulta,$link);
	$reg_nro=0;
	$mostrar_puntos_izq=true;
	while($fila=mysql_fetch_array($result_nro)){
		$reg_nro++;
	}
	$ventana=7;
	$pag_nro=ceil($reg_nro/$paginacion);
	$pag_actual=($ls+$paginacion)/$paginacion;
	if($pag_actual > floor($ventana/2)){
		$ventana_li=$pag_actual - floor($ventana/2);
	}
	else{
		$ventana_li=1;
	}
	$ventana_ls=$ventana_li+$ventana;
	if($ls!=0){
		$atras=$ls-$paginacion;
?>
					<li class="paginador_item"><a href="<?=$PHP_SELF."?ls=".$atras?>">&lt;</a></li>
<?
	}
	for($pag=1;$pag<=$pag_nro;$pag++){
		if($mostrar_puntos_izq && $pag_actual > ceil($ventana/2)){
			$mostrar_puntos_izq=false;
?>
					<li class="paginador_item">...</li>
<?
		}
		if($pag >= $ventana_li && $pag < $ventana_ls){//VENTANA
			$reg_desde=($pag*$paginacion)-$paginacion;
			if($pag==$pag_actual){ //PAGINA ACTUAL
?>
					<li class="paginador_item_actual"><?=$pag?></li>
<?
			}
			else{
?>
					<li class="paginador_item"><a href="<?=$PHP_SELF."?ls=".$reg_desde?>"><?=$pag?></a></li>
<?
			}
		}
	}
	if($pag_actual <= ($pag_nro - ceil($ventana/2))){
?>
					<li class="paginador_item">...</li>
<?
	}
	if($pag_nro > 1 && ($ls+$paginacion) < ($pag_nro*$paginacion)){
		$adelante=$ls+$paginacion;
?>
					<li class="paginador_item"><a href="<?=$PHP_SELF."?ls=".$adelante?>">&gt;</a></li>
<?
	}
?>
				</ul>