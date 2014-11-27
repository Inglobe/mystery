<? 
$ocultar = $db_tareas->getValue("ocultar");
if($ocultar==0){
	if($nivel == 0){
		$puntaje["puntaje"] = 0;
		$puntaje["puntaje_max"] = 0;
?>
<div class="tit_padre gradient_theme"><?=$db_tareas->getXHTMLValue("descripcion")?></div>
<div class="columnas_padre"><div class="puntaje">Puntaje</div><div class="puntaje_max">Pun. Max.</div><div class="comentarios">Comentarios</div></div>
<?  } ?>
<?  if($nivel > 0) {?>
<div class="descripcion"><?=$db_tareas->getXHTMLValue("descripcion")?></div>
<div class="tiempo"><?
	$puntos = $db_tareas->getValue("tiempo");
	$puntaje["puntaje"] += $puntos;
	echo $puntos;
?></div>
<div class="tiempo_max"><?
	$puntajes_perm = $db_tareas->getValue("tiempo_estimado");
	
	$aux = explode(",", $puntajes_perm);
	$puntos_max = array_pop($aux);
	
	$puntaje["puntaje_max"] += $puntos_max;
	
	echo $puntos_max;
?></div>
<div class="obs"><?=$db_tareas->getXHTMLValue("obs")?></div>
<?  } ?>
<? 
	if($nro_hijos_principal == ($orden + 1)) { 
		$puntaje["totales"][] = $puntaje["puntaje"];
		$puntaje["totales_max"][] = $puntaje["puntaje_max"];
		
		$total+= $puntaje["puntaje"]
?>
<div class="pie_padre">
    <div class="subtotal_tit"><strong>Subtotal</strong></div>
    <div class="subtotal color_01"><?=number_format($puntaje["puntaje"],1)?></div>
    <div class="total"><?=number_format($puntaje["puntaje_max"],1)?></div>
</div>
<?  
	} 
}

?>